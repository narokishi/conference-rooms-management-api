<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\ConferenceRoom;

use App\Domain\ConferenceRoom\ConferenceRoomQueryRepositoryInterface;
use App\Domain\Id;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseConferenceRoomQueryRepository
 *
 * @package App\Infrastructure\Persistence\ConferenceRoom
 */
final class DatabaseConferenceRoomQueryRepository extends AbstractDatabaseRepository implements ConferenceRoomQueryRepositoryInterface
{
    /**
     * @param Id $conferenceRoomId
     *
     * @return array|null
     */
    public function findById(Id $conferenceRoomId): ?array
    {
        $query = $this->db->prepare(<<<SQL
            SELECT
              cr.id,
              cr.name,
              cr.created_at,
              cr.updated_at
            FROM
              public.conference_rooms AS cr
            WHERE
              cr.id = :conferenceRoomId
            LIMIT
              1
        SQL);

        $query->execute([
            'conferenceRoomId' => $conferenceRoomId->get(),
        ]);

        return $query->fetch() ?: null;
    }
}
