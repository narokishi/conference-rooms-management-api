<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Logger;
use function App\env;

return fn (ContainerBuilder $containerBuilder) => $containerBuilder->addDefinitions([
    'settings' => [
        'displayErrorDetails' => true,
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => Logger::DEBUG,
        ],
        'db' => [
            'driver' => env('POSTGRES_DRIVER'),
            'host' => env('POSTGRES_HOST'),
            'port' => env('POSTGRES_PORT'),
            'dbname' => env('POSTGRES_DB'),
            'user' => env('POSTGRES_USER'),
            'password' => env('POSTGRES_PASSWORD'),
        ],
    ],
]);
