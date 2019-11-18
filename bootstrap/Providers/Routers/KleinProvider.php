<?php

namespace BaseTemplatePHP\Providers\Routers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Klein\Klein;
use Klein\Request;

class KleinProvider implements ServiceProviderInterface
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
		$klein = new Klein;

		$responds = glob(__DIR__ . '/responds/*.php');
		foreach ($responds as $respond) {
			require $respond;
		}

		// https://github.com/klein/klein.php/wiki/Sub-Directory-Installation
		// $_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], strlen($this->container['settings']['app']['routerStart']));
		$kleinRequest = Request::createFromGlobals();
		$uri = $kleinRequest->server()->get('REQUEST_URI');
		$kleinRequest->server()->set('REQUEST_URI', substr($uri, strlen($container['settings']['app']['routerStart'])));

		// initSubDirectory content
		// $klein->dispatch();  // user $_SERVER['REQUEST_URI]
		$klein->dispatch($kleinRequest);

		$container['klein'] = function ($c) use ($klein) {
			return $klein;
		};
	}
}
