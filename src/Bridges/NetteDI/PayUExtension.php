<?php

/**
 * This file is part of the Nextras\PayU library.
 * @license    MIT
 * @link       https://github.com/nextras/payu
 */

namespace Nextras\PayU\Bridges\NetteDI;

use Nette\DI\CompilerExtension;
use Nextras\PayU\Config;
use Nextras\PayU\InvalidArgumentException;


class PayUExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$optionKeys = ['posId', 'posAuthKey', 'key1', 'key2', 'encoding', 'format'];
		$defaultOptions = [
			'encoding' => Config::ENCODING_UTF_8,
			'format' => Config::FORMAT_XML,
		];

		$container = $this->getContainerBuilder();
		$config = $this->getConfig();

		$searchKeys = array_intersect($optionKeys, array_keys($config));
		if (!empty($searchKeys)) {
			$config = ['default' => $config];
		}

		foreach ($config as $name => $info) {
			if (!is_array($info)) {
				continue;
			}

			if (!isset($info['encoding'])) {
				$info['encoding'] = $defaultOptions['encoding'];
			}

			if (!isset($info['format'])) {
				$info['format'] = $defaultOptions['format'];
			}

			if ($diff = array_diff($optionKeys, array_keys($info))) {
				throw new InvalidArgumentException(sprintf('PayU %s extension: Missing configuration %s keys', $name, implode(', ', $diff)));
			}

			$prefixConfig = $this->prefix($name . '.config');
			$container
				->addDefinition($prefixConfig)
				->setClass('Nextras\PayU\Config')
				->setArguments([
					$info['posId'],
					$info['posAuthKey'],
					$info['key1'],
					$info['key2'],
					$info['encoding'],
					$info['format']
				])
				->setAutowired(FALSE)
				->setInject(FALSE);

			$prefixConnection = $this->prefix($name . '.connection');
			$container
				->addDefinition($prefixConnection)
				->setClass('Nextras\PayU\Connection')
				->setArguments(['@' . $prefixConfig])
				->setAutowired(FALSE)
				->setInject(FALSE);

			$payU = $container
				->addDefinition($this->prefix($name))
				->setClass('Nextras\PayU\PayU')
				->setArguments(array('@' . $prefixConnection));

			if (count($config) !== 1) {
				$payU->setAutowired(FALSE)->setInject(FALSE);
			}
		}
	}

}
