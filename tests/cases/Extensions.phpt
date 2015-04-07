<?php

namespace NextrasTests\PayU;

use Nette\DI\Compiler;
use Nette\DI\Container;
use Nette\DI\ContainerLoader;
use Nextras\PayU;
use Nextras\PayU\Bridges\NetteDI\PayUExtension;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';


class ExtensionTest extends TestCase
{

	/** @return Container */
	protected function createContainer($type)
	{
		$loader = new ContainerLoader(TEMP_DIR);
		$key = __FILE__ . ':' . __LINE__ . ':' . $type;
		$className = $loader->load($key, function (Compiler $compiler) {
			$compiler->addExtension('single', new PayUExtension());
			$compiler->addExtension('multi', new PayUExtension());
			$compiler->loadConfig(__DIR__ . '/files/config.neon');
		});

		return new $className;
	}


	public function testSingleService()
	{
		$dic = $this->createContainer('single');

		Assert::true(($config = $dic->getService('single.default.config')) instanceof PayU\Config);
		Assert::true($dic->getService('single.default.connection') instanceof PayU\Connection);
		Assert::true($dic->getService('single.default') instanceof PayU\PayU);
		Assert::same('txt', $config->getFormat());
	}


	public function testMultiService()
	{
		$dic = $this->createContainer('multi');

		Assert::true(($config = $dic->getService('multi.second.config')) instanceof PayU\Config);
		Assert::true($dic->getService('multi.second.connection') instanceof PayU\Connection);
		Assert::true($dic->getService('multi.second') instanceof PayU\PayU);
		Assert::same('ISO', $config->getEncoding());
	}

}


$test = new ExtensionTest();
$test->run();
