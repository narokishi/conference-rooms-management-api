<?php
declare(strict_types=1);

use App\Domain\Authorization\AuthorizationRepositoryInterface;
use App\Domain\Authorization\Hasher\ArgonHasher;
use App\Domain\Authorization\Hasher\HasherInterface;
use App\Domain\ConferenceRoom\ConferenceRoomCommandRepositoryInterface;
use App\Domain\ConferenceRoom\ConferenceRoomQueryRepositoryInterface;
use App\Domain\Reservation\ReservationQueryRepositoryInterface;
use App\Domain\User\UserQueryRepositoryInterface;
use App\Infrastructure\Persistence\Authorization\DatabaseAuthorizationRepository;
use App\Infrastructure\Persistence\ConferenceRoom\DatabaseConferenceRoomCommandRepository;
use App\Infrastructure\Persistence\ConferenceRoom\DatabaseConferenceRoomQueryRepository;
use App\Infrastructure\Persistence\Reservation\DatabaseReservationQueryRepository;
use App\Infrastructure\Persistence\User\DatabaseUserQueryRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return fn (ContainerBuilder $containerBuilder) => $containerBuilder->addDefinitions([
    // Repositories
    UserQueryRepositoryInterface::class => autowire(DatabaseUserQueryRepository::class),
    AuthorizationRepositoryInterface::class => autowire(DatabaseAuthorizationRepository::class),
    ConferenceRoomQueryRepositoryInterface::class => autowire(DatabaseConferenceRoomQueryRepository::class),
    ConferenceRoomCommandRepositoryInterface::class => autowire(DatabaseConferenceRoomCommandRepository::class),
    ReservationQueryRepositoryInterface::class => autowire(DatabaseReservationQueryRepository::class),

    // Others
    HasherInterface::class => autowire(ArgonHasher::class),
]);
