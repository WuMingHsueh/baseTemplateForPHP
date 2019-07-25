<?php

use \Phpmig\Adapter;

require dirname(__DIR__) . '/dependencies.php';
// $container = new ArrayObject();

// replace this with a better Phpmig\Adapter\AdapterInterface
$container['phpmig.adapter'] = function ($c) {
	return new Adapter\Illuminate\Database($c['db'], 'migrations');
};

$container['phpmig.migrations_path'] = dirname(__DIR__) . '/database/migrations';
$container['phpmig.migrations_template_path'] = dirname(__DIR__) . '/database/templates/defaultTemplate.tmpl';

// You can also provide an array of migration files
// $container['phpmig.migrations'] = array_merge(
//     glob('migrations_1/*.php'),
//     glob('migrations_2/*.php')
// );

return $container;
