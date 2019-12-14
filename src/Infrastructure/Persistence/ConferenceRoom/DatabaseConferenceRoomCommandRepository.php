<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\ConferenceRoom;

use App\Domain\ConferenceRoom\Command\ConferenceRoomCreateCommand;
use App\Domain\ConferenceRoom\ConferenceRoomCommandRepositoryInterface;
use App\Domain\DomainException\InvalidArgumentExceptionAbstract;
use App\Domain\Id;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseConferenceRoomCommandRepository
 *
 * @package App\Infrastructure\Persistence\ConferenceRoom
 */
final class DatabaseConferenceRoomCommandRepository extends AbstractDatabaseRepository implements ConferenceRoomCommandRepositoryInterface
{
    /**
     * @param ConferenceRoomCreateCommand $cmd
     *
     * @return Id
     * @throws InvalidArgumentExceptionAbstract
     */
    public function create(ConferenceRoomCreateCommand $cmd): Id
    {
        $dbQuery = $this->db->prepare(<<<SQL
            INSERT INTO
              conference_rooms (
                name
              )
            VALUES
              (
                :name
              )
            RETURNING
              id
        SQL);

        $dbQuery->execute([
            'name' => $cmd->getName()->get(),
        ]);

        return new Id($dbQuery->fetchColumn());
    }
}
