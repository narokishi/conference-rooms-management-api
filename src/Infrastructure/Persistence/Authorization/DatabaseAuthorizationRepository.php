<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Authorization;

use App\Domain\Authorization\AuthorizationRepositoryInterface;
use App\Domain\Authorization\Query\LoginQuery;
use App\Domain\Id;
use App\Infrastructure\AbstractDatabaseRepository;

/**
 * Class DatabaseAuthorizationRepository
 *
 * @package App\Infrastructure\Persistence\Authorization
 */
final class DatabaseAuthorizationRepository extends AbstractDatabaseRepository implements AuthorizationRepositoryInterface
{
    /**
     * @param LoginQuery $query
     *
     * @return mixed
     * @throws \App\Domain\DomainException\InvalidArgumentExceptionAbstract
     */
    public function getAuthorizedUserId(LoginQuery $query): ?Id
    {
        $dbQuery = $this->db->prepare(<<<SQL
            SELECT
              u.id
            FROM
              users AS u
            WHERE
              u.username = :username
              AND u.password = :password
            LIMIT
              1
        SQL);

        $dbQuery->execute([
            'username' => $query->getUsername()->get(),
            'password' => $query->getPassword()->get(),
        ]);

        return ($userId = $dbQuery->fetchColumn())
            ? new Id($userId) : null;
    }
}
