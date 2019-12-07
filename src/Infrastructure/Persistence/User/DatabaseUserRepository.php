<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\UserDTO;
use App\Domain\User\UserDTOCollection;
use App\Domain\User\UserRepository;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseUserRepository
 *
 * @package App\Infrastructure\Persistence\User
 */
final class DatabaseUserRepository extends AbstractDatabaseRepository implements UserRepository
{
    /**
     * @return UserDTOCollection
     * @throws \App\Domain\Common\Exception\InvalidCollectionItemException
     * @throws \App\Domain\Common\Exception\InvalidCollectionTypeException
     */
    public function findAll(): UserDTOCollection
    {
        $query = $this->db->query(<<<SQL
            SELECT
              u.id,
              u.username,
              u.first_name,
              u.last_name
            FROM
              "user" AS u
        SQL);

        return UserDTOCollection::createFromArray(
            array_map(fn($user) => new UserDTO(
                $user['id'],
                $user['username'],
                $user['first_name'],
                $user['last_name']
            ), $query->fetchAll())
        );
    }
}
