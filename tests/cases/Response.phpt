<?php

namespace NextrasTests\PayU;

use Nextras\PayU\Responses\PaymentInfoResponse;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class ResponseTest extends Tester\TestCase
{

	public function testAssign()
	{
		$response = new PaymentInfoResponse([
			'id' => "123456789",
			'create' => "2014-05-15 17:36:53",
			'sent' => NULL,
			'cancel' => "",
			'ts' => "1400329307029",
			'sig' => "84e1a2ad46dadb0ec4af6de419484e74",
		]);

		Assert::same('123456789', $response->getId());
		Assert::equal(new \DateTime('2014-05-15 17:36:53'), $response->getCreate());
		Assert::same(NULL, $response->getSent());
		Assert::same(NULL, $response->getCancel());
		Assert::same('1400329307029', $response->getTs());
		Assert::same('84e1a2ad46dadb0ec4af6de419484e74', $response->getSig());
	}

}


$test = new ResponseTest();
$test->run();
