<?php

namespace BaseTemplatePHP\Providers\Encryption;

use ParagonIE\Halite\KeyFactory;
use Pimple\Container;

class SodiumKey
{
	public static function readyKey(Container $container)
	{
		KeyFactory::save(KeyFactory::generateAuthenticationKey(), $container['settings']['key']['path']);

		$settings = $container['settings'];
		$settings['key']['content'] = file_get_contents($settings['key']['path']);

		unset($container['settings']);
		$container['settings'] = $settings;
	}
}
