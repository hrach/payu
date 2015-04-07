<?php

namespace NextrasTests\PayU;

use Nextras\PayU\Config;
use Nextras\PayU\Connection;
use Nextras\PayU\Requests\CancelPaymentRequest;
use Nextras\PayU\Requests\PaymentInfoRequest;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ConnectionTest extends Tester\TestCase
{

	public function testGetUrl()
	{
		$connection = new Connection(new Config(12345, 'ab', 'cd', 'ef'));
		Assert::same(Connection::PAYU_URL . '/UTF/Payment/get/xml', $connection->getUrl(new PaymentInfoRequest()));

		$connection = new Connection(new Config(12345, 'ab', 'cd', 'ef', Config::ENCODING_ISO_8859_2, Config::FORMAT_TXT));
		Assert::same(Connection::PAYU_URL . '/ISO/Payment/cancel/txt', $connection->getUrl(new CancelPaymentRequest()));

		$connection = new Connection(new Config(12345, 'ab', 'cd', 'ef', 'uTf', 'xML'));
		Assert::same(Connection::PAYU_URL . '/UTF/Payment/cancel/xml', $connection->getUrl(new CancelPaymentRequest()));
	}


	public function testCheckEncoding()
	{
		Assert::exception(function() {
			$connection = new Connection(new Config(12345, 'ab', 'cd', 'ef', 'WTF-8'));
			$connection->getUrl(new PaymentInfoRequest());
		}, 'Nextras\PayU\LogicException');
	}


	public function testCheckFormat()
	{
		Assert::exception(function() {
			$connection = new Connection(new Config(12345, 'ab', 'cd', 'ef', Config::ENCODING_UTF_8, 'json'));
			$connection->getUrl(new PaymentInfoRequest());
		}, 'Nextras\PayU\LogicException');
	}

}


$test = new ConnectionTest();
$test->run();
