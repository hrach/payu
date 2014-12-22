<?php

namespace Nextras\PayU;

use Nextras\PayU\LogicException;
use Nextras\PayU\Requests\IRequest;
use Nextras\PayU\Requests\Request;
use Kdyby\CurlCaBundle\CertificateHelper;


class Connection
{
	const PAYU_URL = 'https://secure.payu.com/paygw';

	/** @var Config */
	protected $config;


	public function __construct(Config $config)
	{
		$this->config = $config;
	}


	/** @return Config */
	public function getConfig()
	{
		return $this->config;
	}


	/**
	 * @param IRequest $request
	 * @return string
	 */
	public function request(IRequest $request)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getUrl($request));
		curl_setopt($ch, CURLOPT_CAINFO, CertificateHelper::getCaInfoFile());
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getConnectionParameters($this->config));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);

		return $response;
	}


	/**
	 * @param IRequest $request
	 * @return string
	 */
	public function getUrl(IRequest $request)
	{
		return implode('/',
			array(
				self::PAYU_URL, $this->checkAndGetEncoding(), $this->checkAndGetRequestType($request),
				$this->checkAndGetResponseFormat()
			));
	}


	/**
	 * @param IRequest $request
	 * @throws LogicException
	 * @return string
	 */
	private function checkAndGetRequestType(IRequest $request)
	{
		switch ($request->getType()) {
			case Request::NEW_PAYMENT:
			case Request::GET_PAYMENT:
			case Request::CONFIRM_PAYMENT:
			case Request::CANCEL_PAYMENT:
				return $request->getType();
			default:
				throw new LogicException('Not supported request type');
		}
	}


	/**
	 * @throws LogicException
	 * @return string
	 */
	private function checkAndGetEncoding()
	{
		switch ($this->config->getEncoding()) {
			case Config::ENCODING_ISO_8859_2:
			case Config::ENCODING_UTF_8:
			case Config::ENCODING_WINDOWS_1250:
				return $this->config->getEncoding();
			default:
				throw new LogicException('Not supported character encoding');
		}
	}


	/**
	 * @throws LogicException
	 * @return string
	 */
	private function checkAndGetResponseFormat()
	{
		switch ($this->config->getFormat()) {
			case Config::FORMAT_TXT:
			case Config::FORMAT_XML:
				return $this->config->getFormat();
			default:
				throw new LogicException('Not supported response format');
		}
	}

}
