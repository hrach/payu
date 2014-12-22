<?php

namespace NextrasTests\PayU;

use Nextras\PayU\Config;
use Nextras\PayU\Connection;
use Nextras\PayU\Requests\PaymentCancelRequest;
use Nextras\PayU\Requests\PaymentInfoRequest;
use Tester;

require_once __DIR__ . '/../../bootstrap.php';


class ConnectionTest extends Tester\TestCase {

    public function testGetUrl() {
        $connection = new Connection(new Config(12345, 'ab', 'cd', 'ef'));
        Tester\Assert::same(
            Connection::PAYU_URL . '/UTF/Payment/get/xml',
            $connection->getUrl(new PaymentInfoRequest())
        );

        $connection = new Connection(
            new Config(12345, 'ab', 'cd', 'ef', Config::ENCODING_ISO_8859_2, Config::FORMAT_TXT)
        );
        Tester\Assert::same(
            Connection::PAYU_URL . '/ISO/Payment/cancel/txt',
            $connection->getUrl(new PaymentCancelRequest())
        );

        $connection = new Connection(new Config(12345, 'ab', 'cd', 'ef', 'uTf', 'xML'));
        Tester\Assert::same(
            Connection::PAYU_URL . '/UTF/Payment/cancel/xml',
            $connection->getUrl(new PaymentCancelRequest())
        );
    }

    public function testCheckEncoding() {
        Tester\Assert::exception(function () {
            $connection = new Connection(
                new Config(12345, 'ab', 'cd', 'ef', 'WTF-8')
            );
            $connection->getUrl(new PaymentInfoRequest());
        }, '\HostBox\Api\PayU\Exceptions\LogicException');
    }

    public function testCheckFormat() {
        Tester\Assert::exception(function () {
            $connection = new Connection(
                new Config(12345, 'ab', 'cd', 'ef', Config::ENCODING_UTF_8, 'json')
            );
            $connection->getUrl(new PaymentInfoRequest());
        }, '\HostBox\Api\PayU\Exceptions\LogicException');
    }

}

\run(new ConnectionTest());
