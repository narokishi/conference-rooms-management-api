<?php
declare(strict_types=1);

use App\Domain\Authorization\AuthorizationRepositoryInterface;
use App\Domain\Authorization\Hasher\ArgonHasher;
use App\Domain\Authorization\Hasher\HasherInterface;
use App\Domain\ConferenceRoom\ConferenceRoomRepositoryInterface;
use App\Domain\Reservation\ReservationRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Persistence\Authorization\DatabaseAuthorizationRepository;
use App\Infrastructure\Persistence\ConferenceRoom\DatabaseConferenceRoomRepository;
use App\Infrastructure\Persistence\Reservation\DatabaseReservationRepository;
use App\Infrastructure\Persistence\User\DatabaseUserRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return fn (ContainerBuilder $containerBuilder) => $containerBuilder->addDefinitions([
    // Repositories
    UserRepositoryInterface::class => autowire(DatabaseUserRepository::class),
    AuthorizationRepositoryInterface::class => autowire(DatabaseAuthorizationRepository::class),
    ConferenceRoomRepositoryInterface::class => autowire(DatabaseConferenceRoomRepository::class),
    ReservationRepositoryInterface::class => autowire(DatabaseReservationRepository::class),

    // Others
    HasherInterface::class => autowire(ArgonHasher::class),
]);
