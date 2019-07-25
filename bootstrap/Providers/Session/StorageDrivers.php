<?php

namespace BaseTemplatePHP\Providers\Session;

use Stash\Driver\FileSystem;
use Stash\Driver\Sqlite;
use Stash\Driver\Apc;
use Stash\Driver\Redis;
use Stash\Driver\Memcache;

class StorageDrivers
{
	public static function fileSystem($settings): FileSystem
	{
		return new FileSystem(['path' => $settings['session']['fileSystemPath']]);
	}

	public static function sqlite($settings): Sqlite
	{
		return new Sqlite(['path' => $settings['session']['sqlitePath']]);
	}

	public static function apc($settings): Apc
	{
		return new Apc(
			[
				'ttl' => (int) ini_get('session.gc_maxlifetime'),
				'namespace' => $settings['app']['name']
			]
		);
	}

	public static function redis($settings): Redis
	{
		return new Redis(\yaml_parse_file($settings['session']['redis']));
	}

	public static function memcache($settings): Memcache
	{
		return new Memcache(\yaml_parse_file($settings['session']['memcache']));
	}
}
