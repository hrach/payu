<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Requests;

use Nextras\PayU\Config;
use Nextras\PayU\InvalidStateException;


abstract class Request implements IRequest
{
	/** @var string */
	private $sessionId;

	/** @var string */
	private $ts;


	public function __construct()
	{
		$this->setTs(time());
	}


	/**
	 * @return string
	 */
	public function getSessionId()
	{
		$this->sessionId || $this->throwRequired('sessionId');
		return $this->sessionId;
	}


	/**
	 * @param  string $sessionId
	 * @return void
	 */
	public function setSessionId($sessionId)
	{
		$this->sessionId = (string) $sessionId;
	}


	/**
	 * @return string
	 */
	public function getTs()
	{
		return $this->ts;
	}


	/**
	 * @param  string $ts
	 * @return void
	 */
	public function setTs($ts)
	{
		$this->ts = (string) $ts;
	}


	public function getSig(Config $config)
	{
		return md5(
			$config->getPosId() .
			$this->getSessionId() .
			$this->getTs() .
			$config->getKey1()
		);
	}


	public function getParameters()
	{
		return [
			'ts' => $this->getTs(),
			'session_id' => $this->getSessionId(),
		];
	}


	protected function throwRequired($key)
	{
		throw new InvalidStateException("Missing value for '$key' request property.");
	}

}
