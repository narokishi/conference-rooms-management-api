<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Reservation;

use App\Domain\Id;
use App\Domain\Reservation\ReservationQueryRepositoryInterface;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseReservationRepository
 *
 * @package App\Infrastructure\Persistence\Reservation
 */
final class DatabaseReservationQueryRepository extends AbstractDatabaseRepository implements ReservationQueryRepositoryInterface
{
    /**
     * @param Id $reservationId
     *
     * @return array|null
     */
    public function findById(Id $reservationId): ?array
    {
        $query = $this->db->prepare(<<<SQL
            SELECT
              r.id,
              r.user_id,
              CONCAT_WS(' ', u.first_name, u.last_name) AS user_full_name,
              r.conference_room_id,
              cr.name AS conference_room_name,
              r.starts_at,
              r.ends_at,
              r.created_at,
              r.updated_at
            FROM
              public.reservations AS r
            LEFT JOIN
              public.users AS u ON u.id = r.user_id
            LEFT JOIN
              public.conference_rooms AS cr ON cr.id = r.conference_room_id
            WHERE
              r.id = :reservationId
            LIMIT
              1
        SQL);

        $query->execute([
            'reservationId' => $reservationId->get(),
        ]);

        return $query->fetch() ?: null;
    }
}
