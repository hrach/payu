<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Requests;


class PaymentInfoRequest extends Request
{

	/** @inheritdoc */
	public function getType()
	{
		return Request::GET_PAYMENT;
	}


	/** @inheritdoc */
	public function getSig($key)
	{
		return md5($this->posId . $this->sessionId . $this->ts . $key);
	}

}
