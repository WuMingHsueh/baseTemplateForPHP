<?php

namespace BaseTemplatePHP\Providers\Database;

use Illuminate\Database\Capsule\Manager as DB;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class EloquentProvider implements ServiceProviderInterface
{
	/**
	 * Registers services on the given container.
	 *
	 * This method should only be used to configure services and parameters.
	 * It should not get services.
	 *
	 * @param Container $pimple A container instance
	 */
	public function register(Container $container)
	{
		$config = $container['settings']['database'];
		$db = new DB;

		$db->addConnection(
			[
				'driver'   => $config['driver'],
				'host'     => $config['host'],
				'database' => $config['database'],
				'username' => $config['username'],
				'password' => $config['password'],
				'port'     => $config['port'],
				'charset'  => $config['charset'],
			],
			$config['connectionName']
		);

		$db->setAsGlobal();
		$db->bootEloquent();

		$container['db'] = function ($c) use ($db) {
			return $db;
		};
	}
}
