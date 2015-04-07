<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU;

use Nextras\PayU\Requests\IRequest;
use Nextras\PayU\Requests\Request;
use Kdyby\CurlCaBundle\CertificateHelper;


class Connection
{
	const PAYU_URL = 'https://secure.payu.com/paygw';

	/** @var Config */
	private $config;


	public function __construct(Config $config)
	{
		$this->config = $config;
	}


	/**
	 * @return Config
	 */
	public function getConfig()
	{
		return $this->config;
	}


	/**
	 * @param  IRequest $request
	 * @param  array    $parameters
	 * @return string
	 */
	public function request(IRequest $request, array $parameters)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->getUrl($request));
		curl_setopt($ch, CURLOPT_CAINFO, CertificateHelper::getCaInfoFile());
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}


	/**
	 * @param  IRequest $request
	 * @return string
	 */
	public function getUrl(IRequest $request)
	{
		return implode('/',	[
			self::PAYU_URL,
			$this->checkAndGetEncoding(),
			$this->checkAndGetRequestType($request),
			$this->checkAndGetResponseFormat(),
		]);
	}


	/**
	 * @param  IRequest $request
	 * @throws LogicException
	 * @return string
	 */
	private function checkAndGetRequestType(IRequest $request)
	{
		switch ($request->getType()) {
			case Request::CREATE_PAYMENT:
			case Request::PAYMENT_INFO:
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
