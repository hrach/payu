<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Requests;


class PaymentConfirmRequest extends PaymentInfoRequest
{

	/** @inheritdoc */
	public function getType()
	{
		return Request::CONFIRM_PAYMENT;
	}

}
