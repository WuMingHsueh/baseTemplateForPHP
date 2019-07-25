<?php

namespace BaseTemplatePHP\Providers\Encryption;

use Pimple\Container;
use Defuse\Crypto\Key;

class DefuseKey
{
	static public function readyKey(Container $container)
	{
		$key = Key::createNewRandomKey();
		$encodeKey = $key->saveToAsciiSafeString();
		file_put_contents($container['settings']['key']['path'], $encodeKey);

		$settings = $container['settings'];
		$settings['key']['content'] = file_get_contents($settings['key']['path']);

		unset($container['settings']);
		$container['settings'] = $settings;
	}
}
