<?php

$routers = [
	// ["method" => "post", 'path' => "", "controller" => "", "responseMethod" => "", "middlewareLayers" => []],
];

foreach ($routers as $router) {
	$klein->respond($router['method'], $router['path'], function ($request, $response) use ($router, $container) {
		$controller = new $router['controller']($container);
		try {
			// 建立各層middleware物件 並注入相依物件
			$middlewares = \array_map(function ($middlewareClass) use ($container) {
				return new $middlewareClass($container);
			}, $router['middlewareLayers']);

			//將全域middleware 與 區域middleware 組合打包出中介層
			$onion = $container['middleware']->layer($middlewares);

			// 依序執行個中介層邏輯
			return $onion->handle($request, function ($request, $response) use ($controller, $router) {
				return call_user_func([$controller, $router['responseMethod']], $request, $response);
			}, $response);
		} catch (\Exception $e) {
			$response->code($e->getCode());
			return $e->getMessage();
		}
	});
}
