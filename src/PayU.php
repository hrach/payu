<?php

namespace Nextras\PayU;

use Nextras\PayU\Exceptions\LogicException;
use Nextras\PayU\Exceptions\NotImplementedException;
use Nextras\PayU\Exceptions\ResponseException;
use Nextras\PayU\Exceptions\RuntimeException;
use Nextras\PayU\Requests\IRequest;
use Nextras\PayU\Requests\NewPaymentRequest;
use Nextras\PayU\Requests\PaymentCancelRequest;
use Nextras\PayU\Requests\PaymentConfirmRequest;
use Nextras\PayU\Requests\PaymentInfoRequest;
use Nextras\PayU\Requests\Request;
use Nextras\PayU\Responses\IResponse;
use Nextras\PayU\Responses\PaymentActionResponse;
use Nextras\PayU\Responses\PaymentInfoResponse;


class PayU
{
	/** @var Connection */
	private $connection;


	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}


	/** @return Config */
	public function getConfig()
	{
		return $this->connection->getConfig();
	}


	/**
	 * @param IRequest $request
	 * @return string
	 */
	public function getRequestUrl(IRequest $request)
	{
		return $this->connection->getUrl($request);
	}


	/**
	 * @param IRequest $request
	 * @return string
	 */
	public function rawRequest(IRequest $request)
	{
		return $this->connection->request($request);
	}


	/**
	 * @param PaymentInfoRequest $request
	 * @return PaymentInfoResponse
	 */
	public function paymentInfo(PaymentInfoRequest $request)
	{
		return $this->createResponseEntity($request);
	}


	/**
	 * @param PaymentCancelRequest $request
	 * @return PaymentActionResponse
	 */
	public function cancelPayment(PaymentCancelRequest $request)
	{
		return $this->createResponseEntity($request);
	}


	/**
	 * @param PaymentConfirmRequest $request
	 * @return PaymentActionResponse
	 */
	public function confirmPayment(PaymentConfirmRequest $request)
	{
		return $this->createResponseEntity($request);
	}


	/**
	 * @param IResponse $response
	 * @return bool
	 */
	public function isResponseValid(IResponse $response)
	{
		return $response->isSigValid($this->getConfig()->getKey2());
	}


	/**
	 * @param IRequest $request
	 * @return void
	 */
	public function prepareEntityForRequest(IRequest &$request)
	{
		if ($request instanceof NewPaymentRequest) {
			if ($request->getPosAuthKey() === NULL) {
				$request->setPosAuthKey($this->getConfig()->getPosAuthKey());
			}
			if ($request->getPosId() === NULL) {
				$request->setPosId($this->getConfig()->getPosId());
			}
		} elseif ($request instanceof PaymentInfoRequest) {
			if ($request->getPosId() === NULL) {
				$request->setPosId($this->getConfig()->getPosId());
			}
		}
	}


	/**
	 * @param IRequest $request
	 * @return string
	 */
	public function getRequestSig(IRequest $request)
	{
		return $request->getSig($this->getConfig()->getKey1());
	}


	/**
	 * @param IRequest $request
	 * @throws NotImplementedException
	 * @throws RuntimeException
	 * @throws LogicException
	 * @throws ResponseException
	 * @return mixed
	 */
	private function createResponseEntity(IRequest $request)
	{
		$this->prepareEntityForRequest($request);
		$response = $this->connection->request($request);
		switch ($this->connection->getConfig()->getFormat()) {
			case Config::FORMAT_XML: {
				if (($xml = @simplexml_load_string($response)) === FALSE) {
					throw new RuntimeException('Response is not valid XML');
				}

				$status = strtoupper((string) $xml->status);
				if ($status == 'ERROR') {
					throw new ResponseException((string) $xml->error->message, (int) $xml->error->nr);
				} else {
					if ($status == 'OK') {
						switch ($request->getType()) {
							case Request::GET_PAYMENT:
								return new PaymentInfoResponse((array) $xml->trans);
							case Request::CONFIRM_PAYMENT:
							case Request::CANCEL_PAYMENT:
								return new PaymentActionResponse((array) $xml->trans);
							case Request::NEW_PAYMENT:
							default:
								throw new LogicException('Not supported request type for response');
						}
					} else {
						throw new ResponseException('Unknown response status');
					}
				}
			}
			case Config::FORMAT_TXT:
				throw new NotImplementedException('Not implemented response format');
			default:
				throw new LogicException('Not supported response format');
		}
	}

}
