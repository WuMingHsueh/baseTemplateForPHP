<?php

namespace BaseTemplatePHP\Providers\Routers;

use Klein\klein;
use Pimple\Container;

class BaseRespond
{
	public function responds(Container &$container, klein &$klein)
	{ }

	private function provideMiddleware(array $middlewares, $container, $request, $response, $controller, $method)
	{
		// 創建 onion 並在各層中注入相依物件
		$onion = new Onion(\array_map(function ($class) use ($container) {
			return new $class($container);
		}, $middlewares));

		// 依序執行個中介層邏輯
		return $onion->handle($request, function ($request, $response) use ($controller, $method) {
			return $controller->{$method}($request, $response);
		}, $response);
	}
}
