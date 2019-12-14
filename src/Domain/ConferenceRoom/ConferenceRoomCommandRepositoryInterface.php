<?php
declare(strict_types=1);

namespace App\Domain\ConferenceRoom;

use App\Domain\ConferenceRoom\Command\ConferenceRoomCreateCommand;
use App\Domain\Id;

/**
 * Interface ConferenceRoomCommandRepositoryInterface
 *
 * @package App\Domain\ConferenceRoom
 */
interface ConferenceRoomCommandRepositoryInterface
{
    /**
     * @param ConferenceRoomCreateCommand $cmd
     *
     * @return Id
     */
    public function create(ConferenceRoomCreateCommand $cmd): Id;
}
