<?php

require dirname(dirname(__DIR__)) . "/vendor/autoload.php";

require dirname(__DIR__) . '/dependencies.php';

PhpmigExample\Providers\Encryption\SodiumKey::readyKey($container);
// PhpmigExample\Providers\Encryption\DefuseKey::readyKey($container);
