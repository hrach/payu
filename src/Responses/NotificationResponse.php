<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Responses;


class NotificationResponse extends Response
{

	/** @inheritdoc */
	public function isSigValid($key2)
	{
		return ($this->getSig() == md5($this->getPosId() . $this->getSessionId() . $this->getTs() . $key2));
	}

}
