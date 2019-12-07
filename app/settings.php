<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;

return fn (ContainerBuilder $containerBuilder) => $containerBuilder->addDefinitions([
    'settings' => [
        'displayErrorDetails' => true, // Should be set to false in production
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],
        'db' => [
            'driver' => 'pgsql',
            'host' => 'crma_pgsql',
            'port' => '5432',
            'dbname' => 'crma',
            'user' => 'crma_app',
            'password' => 'pwd123',
        ],
    ],
]);
