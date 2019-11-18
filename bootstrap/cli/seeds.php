<?php

require dirname(dirname(__DIR__)) . "/vendor/autoload.php";
require dirname(__DIR__) . '/dependencies.php';

use BaseTemplatePHP\Providers\Database\SeedsProvider;

$method = $argv[1] ?? 'all';
$factoriesPath = dirname(__DIR__) . '/database/factories';
$seeds = new SeedsProvider($container, $factoriesPath);
if (method_exists($seeds, $method)) {
	$seeds->{$method}();
} else {
	echo "seed table not exists", PHP_EOL;
}
