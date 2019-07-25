<?php

namespace BaseTemplatePHP\Providers\Routers;

use Klein\klein;
use Pimple\Container;

class RespondPages extends BaseRespond
{
	private $routersPage = [
		// ["method" => "get", 'path' => "", "controller" => "", "responseMethod" => "", "viewLayout" => "", "viewRender" => "", "middlewareLayers" => []],
	];

	public function responds(Container &$container, klein &$klein)
	{
		foreach ($this->routersPage as $routerPage) {
			$klein->respond($routerPage['method'], $routerPage['path'], function ($request, $response, $service) use ($routerPage, &$container) {
				$container['page'] = function ($c) use ($service) {
					return  $service;
				};
				$controller = new $routerPage['controller']($container);
				if ((empty($routerPage['middlewareLayers']))) {
					call_user_func([$controller, $routerPage['responseMethod']], $request, $response);
				} else {
					$this->provideMiddleware(
						$routerPage['middlewareLayers'],
						$container,
						$request,
						$response,
						$controller,
						$routerPage['responseMethod']
					);
				}
				$service = $container['page'];
				unset($container['page']);  // 清空Service 以防下一個router使用時發生Service frozen
			});
		}
	}
}
