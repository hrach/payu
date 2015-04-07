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

	/**
	 * @param Config $config
	 * @return string
	 */
	public function getConnectionParameters(Config $config);


	/** @return string */
	public function getType();


	/**
	 * @param string $key
	 * @return string
	 */
	public function getSig($key);

}
