<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Requests;


class ConfirmPaymentRequest extends Request
{

	public function getType()
	{
		return self::CONFIRM_PAYMENT;
	}

}
