<?php

declare(strict_types=1);

$autoload = dirname(__DIR__) . '/vendor/autoload.php';

if (!is_file($autoload)) {
    throw new RuntimeException('Faltan las dependencias. Ejecuta: composer install');
}

require $autoload;

$localConfig = __DIR__ . '/local.php';
if (is_file($localConfig)) {
    $values = require $localConfig;
    foreach ($values as $name => $value) {
        if (getenv((string) $name) === false) {
            putenv(sprintf('%s=%s', $name, $value));
        }
    }
}

