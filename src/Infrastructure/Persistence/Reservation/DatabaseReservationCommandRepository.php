<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Reservation;

use App\Domain\ConferenceRoom\Command\ConferenceRoomCreateCommand;
use App\Domain\DomainException\InvalidArgumentExceptionAbstract;
use App\Domain\Id;
use App\Domain\Reservation\Command\ReservationCreateCommand;
use App\Domain\Reservation\ReservationCommandRepositoryInterface;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseReservationCommandRepository
 *
 * @package App\Infrastructure\Persistence\Reservation
 */
final class DatabaseReservationCommandRepository extends AbstractDatabaseRepository implements ReservationCommandRepositoryInterface
{
    /**
     * @param ReservationCreateCommand $cmd
     *
     * @return Id
     * @throws InvalidArgumentExceptionAbstract
     */
    public function create(ReservationCreateCommand $cmd): Id
    {
        $dbQuery = $this->db->prepare(<<<SQL
            INSERT INTO
              reservations (
                conference_room_id,
                user_id,
                starts_at,
                ends_at
              )
            VALUES
              (
                :conferenceRoomId,
                :userId,
                :startsAt,
                :endsAt
              )
            RETURNING
              id
        SQL);

        $dbQuery->execute([
            'conferenceRoomId' => $cmd->getConferenceRoomId()->get(),
            'userId' => $cmd->getUserId()->get(),
            'startsAt' => $cmd->getStartsAt()->get(),
            'endsAt' => $cmd->getEndsAt()->get(),
        ]);

        return new Id($dbQuery->fetchColumn());
    }
}
