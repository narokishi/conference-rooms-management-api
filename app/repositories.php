<?php
declare(strict_types=1);

use App\Domain\Authorization\AuthorizationRepositoryInterface;
use App\Domain\Authorization\Hasher\HasherInterface;
use App\Domain\Authorization\Hasher\PlainTextHasher;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\Authorization\DatabaseAuthorizationRepository;
use App\Infrastructure\Persistence\User\DatabaseUserRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return fn (ContainerBuilder $containerBuilder) => $containerBuilder->addDefinitions([
    // Repositories
    UserRepositoryInterface::class => autowire(DatabaseUserRepository::class),
    AuthorizationRepositoryInterface::class => autowire(DatabaseAuthorizationRepository::class),

    // Others
    HasherInterface::class => autowire(PlainTextHasher::class),
]);
