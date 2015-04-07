<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Requests;

use Nextras\PayU\Config;


interface IRequest
{
	const CREATE_PAYMENT = 'NewPayment';
	const CONFIRM_PAYMENT = 'Payment/confirm';
	const CANCEL_PAYMENT = 'Payment/cancel';
	const PAYMENT_INFO = 'Payment/get';


	/**
	 * @return array
	 */
	public function getParameters();


	/**
	 * @return string
	 */
	public function getType();


	/**
	 * @param  Config $config
	 * @return string
	 */
	public function getSig(Config $config);

}
