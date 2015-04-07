<?php

namespace NextrasTests\PayU;

use Nextras\PayU\Config;
use Nextras\PayU\Requests\CreatePaymentRequest;
use Nextras\PayU\Requests\CancelPaymentRequest;
use Nextras\PayU\Requests\ConfirmPaymentRequest;
use Nextras\PayU\Requests\PaymentInfoRequest;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class RequestTest extends Tester\TestCase
{

	public function testGetSig()
	{
		$config = new Config(123, 'abcdefg', 'key1Test', '_');
		$request = new PaymentInfoRequest();
		$request->setSessionId(456);
		$request->setTs(123456789);
		Assert::same('ab15a0d44bf9daaa61870ed033b22d88', $request->getSig($config));


		$config = new Config(456, 'abcdefg', 'key1Test2', '_');
		$request = new CancelPaymentRequest();
		$request->setSessionId(123);
		$request->setTs(987654321);
		Assert::same('0ece2c7ddc02ccff2e094eb1e1ec34ed', $request->getSig($config));


		$config = new Config(159, 'abcdefg', 'key1Test3', '_');
		$request = new ConfirmPaymentRequest();
		$request->setSessionId(753);
		$request->setTs(589632147);
		Assert::same('4f194190efec696dbf8c98d2c845e5f3', $request->getSig($config));


		$config = new Config('1234', 'abcdefg', 'key1Test4', 'key2');
		$createPaymentRequest = new CreatePaymentRequest();
		$createPaymentRequest->setSessionId(123);
		$createPaymentRequest->setAmount(10000);
		$createPaymentRequest->setDesc('TEST');
		$createPaymentRequest->setClientIp('127.0.0.1');
		$createPaymentRequest->setFirstName('Name');
		$createPaymentRequest->setLastName('Surname');
		$createPaymentRequest->setEmail('test@test.test');
		$createPaymentRequest->setLanguage('cs');
		$createPaymentRequest->setTs(123456789);

		Assert::same('4c39152d4c2ccdee06e6a0c9381ef012', $createPaymentRequest->getSig($config));
	}

}


$test = new RequestTest();
$test->run();
