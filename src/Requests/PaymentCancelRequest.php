<?php

namespace Nextras\PayU\Requests;


class PaymentCancelRequest extends PaymentInfoRequest
{

	/** @inheritdoc */
	public function getType()
	{
		return Request::CANCEL_PAYMENT;
	}

}
