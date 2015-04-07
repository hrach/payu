<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU;


class Strings
{

	/**
	 * camelCase -> underdash_separated.
	 *
	 * @param  string
	 * @return string
	 */
	public static function camelToUnderdash($s)
	{
		$s = preg_replace('#(.)(?=[A-Z])#', '$1_', $s);
		$s = strtolower($s);
		$s = rawurlencode($s);

		return $s;
	}


	/**
	 * underdash_separated -> camelCase
	 *
	 * @param  string
	 * @return string
	 */
	public static function underdashToCamel($s)
	{
		$s = strtolower($s);
		$s = preg_replace('#_(?=[a-z])#', ' ', $s);
		$s = substr(ucwords('x' . $s), 1);
		$s = str_replace(' ', '', $s);

		return $s;
	}

}
