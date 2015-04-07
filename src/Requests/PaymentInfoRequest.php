<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Requests;


class PaymentInfoRequest extends Request
{

	public function getType()
	{
		return self::PAYMENT_INFO;
	}

}
