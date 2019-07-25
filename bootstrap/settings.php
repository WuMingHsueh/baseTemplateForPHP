<?php

//define project root path
defined('DS') ?: define('DS', DIRECTORY_SEPARATOR);
defined('PROJECT_ROOT') ?: define('PROJECT_ROOT', dirname(__DIR__) . DS);

// load .env config file
if (file_exists(PROJECT_ROOT . '.env')) {
	$dotenv = Dotenv\Dotenv::create(PROJECT_ROOT);
	$dotenv->load();
}

$warehousePath = dirname((isset($_SERVER['DOCUMENT_ROOT']) and $_SERVER['DOCUMENT_ROOT'] != '') ? $_SERVER['DOCUMENT_ROOT'] : dirname(PROJECT_ROOT)) . DS . "phpWarehouse" . DS . getenv('APP_NAME') . DS;
$databaseIniPath = $warehousePath . "config" . DS . "database.ini";
$keyIniPath = $warehousePath . "config" . DS . "key.ini";
$mailIniPath = $warehousePath . "config" . DS . "mail.ini";
$cachePath = $warehousePath . 'cache' . DS;

$dbConfig = parse_ini_file($databaseIniPath);
$mailConfig = parse_ini_file($mailIniPath);

return [
	'displayErrorDetails'    => getenv('APP_DEBUG') === 'true' ? true : false, // set to false in production
	'addContentLengthHeader' => false, // Allow the web server to send the content-length header

	// App Settings
	'app'                    => [
		'name'        => getenv('APP_NAME'),
		'url'         => getenv('APP_URL'),
		'env'         => getenv('APP_ENV'),
		'routerStart' => getenv('APP_ROUTER_START'),
	],

	// key
	'key'                    => [
		'path'    => $keyIniPath,
		'content' => file_get_contents($keyIniPath),
	],

	// session settings
	'session'                => [
		'fileSystemPath' => $cachePath,
		'sqlitePath'     => $cachePath,
		// 'redis'          => yaml_parse_file($warehousePath . "config" . DS . 'cache.yml'),
		// 'memcache'       => yaml_parse_file($warehousePath . "config" . DS . 'cache.yml'),
	],

	// project warehouse
	'warehouse' => [
		'path'   => $warehousePath,
		'upload' => $warehousePath . 'upload' . DS,
	],

	// Monolog settings
	'logger'                 => [
		'name'  => getenv('APP_NAME'),
		'path'  => isset($_ENV['docker']) ? 'php://stdout' : $warehousePath . 'log' . DS . 'debug.log',
		// 'level' => \Monolog\Logger::DEBUG,
	],

	// Database settings
	'database'           => [
		'connectionName' => 'default',
		'driver'         => $dbConfig['driver'],
		'host'           => $dbConfig['host'],
		'database'       => $dbConfig['database'],
		'username'       => $dbConfig['username'],
		'password'       => $dbConfig['password'],
		'port'           => $dbConfig['port'],
		'charset'        => $dbConfig['charset']
	],

	'cors' => null !== getenv('CORS_ALLOWED_ORIGINS') ? getenv('CORS_ALLOWED_ORIGINS') : '*',
];
