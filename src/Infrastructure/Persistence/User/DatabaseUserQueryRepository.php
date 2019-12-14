<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\Id;
use App\Domain\User\UserQueryRepositoryInterface;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseUserRepository
 *
 * @package App\Infrastructure\Persistence\User
 */
final class DatabaseUserQueryRepository extends AbstractDatabaseRepository implements UserQueryRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = $this->db->query(<<<SQL
            SELECT
              u.id,
              u.username,
              u.first_name,
              u.last_name
            FROM
              public.users AS u
        SQL);

        return $query->fetchAll();
    }

    /**
     * @param Id $userId
     *
     * @return array|null
     */
    public function findById(Id $userId): ?array
    {
        $query = $this->db->prepare(<<<SQL
            SELECT
              u.id,
              u.username,
              u.first_name,
              u.last_name
            FROM
              public.users AS u
            WHERE
              u.id = :userId
            LIMIT
              1
        SQL);

        $query->execute([
            'userId' => $userId->get(),
        ]);

        return $query->fetch() ?: null;
    }
}
