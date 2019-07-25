<?php

namespace BaseTemplatePHP\Providers\Session;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Stash\Pool;
use Stash\Session;

class SessionService implements ServiceProviderInterface
{
	public function register(Container $container)
	{
		$pool = new Pool(StorageDrivers::fileSystem($container['settings']));
		$container['session'] = function ($c) use ($pool) {
			return new Session($pool);
		};
	}
}
