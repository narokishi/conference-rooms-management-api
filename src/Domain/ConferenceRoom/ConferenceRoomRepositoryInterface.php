<?php
declare(strict_types=1);

namespace App\Domain\ConferenceRoom;

use App\Domain\Id;

/**
 * Interface ConferenceRoomRepositoryInterface
 *
 * @package App\Domain\ConferenceRoom
 */
interface ConferenceRoomRepositoryInterface
{
    /**
     * @param Id $conferenceRoomId
     *
     * @return array|null
     */
    public function findById(Id $conferenceRoomId): ?array;
}
