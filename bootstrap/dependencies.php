<?php

use Pimple\Container;

$container = new Container();
$container['settings'] = function ($c) {
	return require __DIR__ . '/settings.php';
};
$container->register(new BaseTemplatePHP\Providers\Database\EloquentProvider);
// $container->register(new BaseTemplatePHP\Service\Session\SessionService);
