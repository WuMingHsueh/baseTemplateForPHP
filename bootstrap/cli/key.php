<?php

require dirname(dirname(__DIR__)) . "/vendor/autoload.php";

require dirname(__DIR__) . '/dependencies.php';

BaseTemplatePHP\Providers\Encryption\SodiumKey::readyKey($container);
// BaseTemplatePHP\Providers\Encryption\DefuseKey::readyKey($container);
