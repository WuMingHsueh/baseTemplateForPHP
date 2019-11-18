<?php

namespace BaseTemplatePHP\Service\Example;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ExampleService implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		// Service 須先註冊至 bootstrap/dependencies.php
		$container['ServiceName'] = function ($c) {
			return new Csrf($c['settings']);
		};
	}
}
