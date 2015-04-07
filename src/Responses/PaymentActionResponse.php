<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Responses;


class PaymentActionResponse extends Response
{
	/** @var int */
	protected $id;


	/** @return int */
	public function getId()
	{
		return $this->id;
	}


	/** @inheritdoc */
	public function isSigValid($key2)
	{
		return ($this->getSig() == md5($this->getPosId() . $this->getSessionId() . $this->getTs() . $key2));
	}

}
