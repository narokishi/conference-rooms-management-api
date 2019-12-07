<?php
declare(strict_types=1);

use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\User\DatabaseUserRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return fn (ContainerBuilder $containerBuilder) => $containerBuilder->addDefinitions([
    UserRepositoryInterface::class => autowire(DatabaseUserRepository::class),
]);
