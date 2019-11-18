<?php

$container['middleware'] = function ($c) {
	$globMiddlewares = [];
	// global middlewares class 放在 ./Providers/Middleware/Global/ 中
	foreach (glob(__DIR__ . "/Providers/Middleware/Global/*.php") as $file) {
		$class = 'BaseTemplatePHP\Providers\Middleware\Global\\' . basename($file, '.php');
		$globMiddlewares[] = new $class($c);
	}
	return new BaseTemplatePHP\Providers\Middleware\Onion($globMiddlewares);
};
