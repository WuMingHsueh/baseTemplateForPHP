<?php

$container['middleware'] = function ($c) {
	$globMiddlewares = [];
	// global middlewares class 放在 ./Providers/Middleware/Global/ 中
	foreach (glob(__DIR__ . "/Providers/Middleware/Global/*.php") as $file) {
		$class = 'PurchaseSalesInventory\Providers\Middleware\Global\\' . basename($file, '.php');
		$globMiddlewares[] = new $class($c);
	}
	return new PurchaseSalesInventory\Providers\Middleware\Onion($globMiddlewares);
};
