<?php

use BaseTemplatePHP\Providers\Exception\PageException;

$routersPages = [
	// ["method" => "get", 'path' => "", "controller" => "", "responseMethod" => "", "viewLayout" => "", "viewRender" => "", "middlewareLayers" => []],
];

foreach ($routersPages as $routerPage) {
	$klein->respond($routerPage['method'], $routerPage['path'], function ($request, $response, $service) use ($routerPage, &$container) {
		$container['page'] = $service;
		$controller = new $routerPage['controller']($container);
		try {
			// 建立各層middleware物件 並注入相依物件
			$middlewares = \array_map(function ($middlewareClass) use ($container) {
				return new $middlewareClass($container);
			}, $routerPage['middlewareLayers']);

			//將全域middleware 與 區域middleware 組合打包出中介層
			$onion = $container['middleware']->layer($middlewares);

			// 依序執行個中介層邏輯
			return $onion->handle($request, function ($request, $response) use ($controller, $routerPage) {
				return call_user_func([$controller, $routerPage['responseMethod']], $request, $response);
			}, $response);
			$service = $container['page'];
			unset($container['page']);  // 清空Service 以防下一個router使用時發生Service frozen
		} catch (PageException $e) {
			$service->routerRoot = $container['settings']['app']['routerStart'];
			$service->assetPath = $container['settings']['renderer']['assetPath'];
			$service->componentsPath = $container['settings']['renderer']['componentsPath'];
			$service->layout($container['settings']['renderer']['templatePath'] . "error.php");
			$service->render($container['settings']['renderer']['componentsPath'] . 'errors/' . $e->getComponentPath(), [
				'code'      => $e->getCode(),
				'message'   => $e->getMessage(),
				'file'      => $e->getFile(),
				'line'      => $e->getLine(),
				'trace'     => $e->getTraceAsString(),
				'component' => $e->getComponentPath(),
				'data'      => $e->getData()
			]);
		}
	});
}
