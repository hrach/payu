<?php

namespace NextrasTests\PayU;

use Nextras\PayU\Config;
use Nextras\PayU\Connection;
use Nextras\PayU\PayU;
use Nextras\PayU\Requests\CreatePaymentRequest;
use Tester;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


class PayUTest extends Tester\TestCase
{

	public function testCreatePaymentRedirectUrl()
	{
		$config = new Config(1234, 'abcdefg', 'key1', 'key2');

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

		$connection = new Connection($config);
		$payu = new PayU($connection);


		$refUrl = 'https://secure.payu.com/paygw/UTF/NewPayment/xml?pos_auth_key=abcdefg&amount=10000&desc=TEST&first_name=Name&last_name=Surname&email=test%40test.test&language=cs&client_ip=127.0.0.1&pos_id=1234&session_id=123&ts=123456789&sig=eabc4e2e2825c51743b3ed673db6fb99';
		$genUrl = $payu->getCreatePaymentRedirectUrl($createPaymentRequest);
		Assert::true($this->compareParams($refUrl, $genUrl));


		$createPaymentRequest->setAmount(9999);
		$createPaymentRequest->setDesc2('lorem');
		$refUrl = 'https://secure.payu.com/paygw/UTF/NewPayment/xml?pos_auth_key=abcdefg&amount=9999&desc=TEST&desc2=lorem&first_name=Name&last_name=Surname&email=test%40test.test&language=cs&client_ip=127.0.0.1&pos_id=1234&session_id=123&ts=123456789&sig=9d72e0f7010db0f911131d2a86eb48e0';
		$genUrl = $payu->getCreatePaymentRedirectUrl($createPaymentRequest);
		Assert::true($this->compareParams($refUrl, $genUrl));


		Assert::exception(function() use ($payu) {
			$request = new CreatePaymentRequest();
			$payu->getCreatePaymentRedirectUrl($request);
		}, 'Nextras\PayU\LogicException');
	}


	private function compareParams($refUrl, $genUrl)
	{
		$url1 = parse_url($refUrl);
		$url2 = parse_url($genUrl);

		parse_str($url1['query'], $query1);
		parse_str($url2['query'], $query2);

		ksort($query1);
		ksort($query2);
		return $query1 === $query2;
	}

}


$test = new PayUTest();
$test->run();
