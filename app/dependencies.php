<?php
declare(strict_types=1);

use App\Domain\Translation\Translation;
use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function App\getCookie;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        \PDO::class => function (ContainerInterface $c) {
            $dbSettings = (object) $c->get('settings')['db'];

            $pdo = new \PDO(sprintf(
                '%s:host=%s;port=%d;dbname=%s;user=%s;password=%s',
                $dbSettings->driver,
                $dbSettings->host,
                $dbSettings->port,
                $dbSettings->dbname,
                $dbSettings->user,
                $dbSettings->password
            ));

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL);

            return $pdo;
        },
        Translation::class => function (ContainerInterface $c) {
            $settingsLanguage = $c->get('settings')['language'] ?? null;

            return new Translation(
                getCookie('X-Language') ?: $settingsLanguage
            );
        }
    ]);
};
