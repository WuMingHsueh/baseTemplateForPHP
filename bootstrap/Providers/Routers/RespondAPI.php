<?php

namespace BaseTemplatePHP\Providers\Routers;

use Klein\klein;
use Pimple\Container;

class RespondAPI extends BaseRespond
{
	private $routers = [
		// ["method" => "post", 'path' => "", "controller" => "", "responseMethod" => "", "middlewareLayers" => []],

	];

	public function responds(Container &$container, klein &$klein)
	{
		foreach ($this->routers as $router) {
			$klein->respond($router['method'], $router['path'], function ($request, $response) use ($router, &$container) {
				$controller = new $router['controller']($container);
				try {
					if ((empty($router['middlewareLayers']))) {
						return call_user_func([$controller, $router['responseMethod']], $request, $response);
					} else {
						return $this->provideMiddleware(
							$router['middlewareLayers'],
							$container,
							$request,
							$response,
							$controller,
							$router['responseMethod']
						);
					}
				} catch (\Exception $e) {
					$response->code($e->getCode());
					return $e->getMessage();
				}
			});
		}
	}
}
