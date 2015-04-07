<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU;


class InvalidArgumentException extends \InvalidArgumentException
{
}


class LogicException extends \LogicException
{
}


class InvalidStateException extends LogicException
{
}


class NotImplementedException extends \LogicException
{
}


class ResponseException extends \LogicException
{
}


class RuntimeException extends \RuntimeException
{
}
