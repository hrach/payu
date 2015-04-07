<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Responses;


interface IResponse
{

	/** @return string */
	public function getPosId();


	/** @return string */
	public function getSig();


	/** @return string */
	public function getTs();


	/** @return string */
	public function getSessionId();


	/**
	 * @param string $key2
	 * @return bool
	 */
	public function isSigValid($key2);

}
