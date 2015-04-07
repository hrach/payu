<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU;

use Nextras\PayU\Requests\IRequest;
use Nextras\PayU\Requests\CreatePaymentRequest;
use Nextras\PayU\Requests\CancelPaymentRequest;
use Nextras\PayU\Requests\ConfirmPaymentRequest;
use Nextras\PayU\Requests\PaymentInfoRequest;
use Nextras\PayU\Requests\Request;
use Nextras\PayU\Responses\PaymentActionResponse;
use Nextras\PayU\Responses\PaymentInfoResponse;


class PayU
{
	const CHANNEL_BTN_CS = 'cs';
	const CHANNEL_BTN_MB = 'mp';
	const CHANNEL_BTN_KB = 'kb';
	const CHANNEL_BTN_RB = 'rf';
	const CHANNEL_BTN_GE = 'pg';
	const CHANNEL_BTN_SB = 'pv';
	const CHANNEL_BTN_FB = 'pf';
	const CHANNEL_BTN_ERA = 'era';
	const CHANNEL_BTN_CSOB = 'cb';
	const CHANNEL_PAYSEC = 'psc';
	const CHANNEL_CARD = 'c';
	const CHANNEL_MOBITO = 'mo';
	const CHANNEL_WIRE_TRANSFER = 'bt';
	const CHANNEL_POST_TRANSFER = 'pt';
	const CHANNEL_TEST = 't';

	/** @var Connection */
	private $connection;


	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}


	/**
	 * @param  PaymentInfoRequest $request
	 * @return PaymentInfoResponse
	 */
	public function sendPaymentInfo(PaymentInfoRequest $request)
	{
		return $this->createResponseEntity($request);
	}


	/**
	 * @param  CancelPaymentRequest $request
	 * @return PaymentActionResponse
	 */
	public function sendCancelPayment(CancelPaymentRequest $request)
	{
		return $this->createResponseEntity($request);
	}


	/**
	 * @param  ConfirmPaymentRequest $request
	 * @return PaymentActionResponse
	 */
	public function sendConfirmPayment(ConfirmPaymentRequest $request)
	{
		return $this->createResponseEntity($request);
	}


	/**
	 * @param  CreatePaymentRequest $request
	 * @return string
	 */
	public function getCreatePaymentRedirectUrl(CreatePaymentRequest $request)
	{
		$url = $this->connection->getUrl($request);
		$parameters = [];
		foreach ($this->getRequestParameters($request) as $name => $value) {
			$parameters[] = $name . '=' . urlencode($value);
		}
		return $url . '?' . implode('&', $parameters);
	}


	protected function getRequestParameters(IRequest $request)
	{
		$config = $this->connection->getConfig();

		$parameters = $request->getParameters();
		$parameters = array_filter($parameters, function($value) {
			return $value !== NULL;
		});

		$parameters['pos_id'] = $config->getPosId();
		$parameters['sig'] = $request->getSig($config);

		if ($request->getType() === IRequest::CREATE_PAYMENT) {
			$parameters['pos_auth_key'] = $config->getPosAuthKey();
		}

		return $parameters;
	}


	protected function createResponseEntity(IRequest $request)
	{
		if ($this->connection->getConfig()->getFormat() !== Config::FORMAT_XML) {
			throw new NotImplementedException();
		}

		$parameters = $this->getRequestParameters($request);
		$response = $this->connection->request($request, $parameters);

		if (($xml = @simplexml_load_string($response)) === FALSE) {
			throw new RuntimeException('Response is not valid XML');
		}

		$status = strtoupper((string) $xml->status);
		if ($status !== 'ERROR') {
			throw new ResponseException((string) $xml->error->message, (int) $xml->error->nr);
		} elseif ($status !== 'OK') {
			throw new ResponseException('Unknown response status');
		}

		switch ($request->getType()) {
			case Request::PAYMENT_INFO:
				$response = new PaymentInfoResponse((array) $xml->trans);
				break;

			case Request::CONFIRM_PAYMENT:
			case Request::CANCEL_PAYMENT:
				$response = new PaymentActionResponse((array) $xml->trans);
				break;

			case Request::CREATE_PAYMENT:
			default:
				throw new LogicException('Not supported request type for response');
		}

		if (!$response->isSigValid($this->connection->getConfig()->getKey2())) {
			throw new LogicException('Response has not valid signature.');
		}

		return $response;
	}

}
