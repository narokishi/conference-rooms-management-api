<?php
declare(strict_types=1);

namespace App\Infrastructure\Persistence\Authorization;

use App\Domain\Authorization\AuthorizationRepositoryInterface;
use App\Domain\Authorization\DTO\AuthorizationUserDTO;
use App\Domain\Authorization\Command\RegisterCommand;
use App\Domain\Authorization\Query\LoginQuery;
use App\Domain\DomainException\InvalidArgumentExceptionAbstract;
use App\Domain\Id;
use App\Domain\Text;
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
     * @return AuthorizationUserDTO|null
     * @throws InvalidArgumentExceptionAbstract
     */
    public function getAuthorizationUser(LoginQuery $query): ?AuthorizationUserDTO
    {
        $dbQuery = $this->db->prepare(<<<SQL
            SELECT
              u.id,
              u.password,
              u.username
            FROM
              users AS u
            WHERE
              u.username = :username
            LIMIT
              1
        SQL);

        $dbQuery->execute([
            'username' => $query->getUsername()->get(),
        ]);

        return ($authorizationUser = $dbQuery->fetch())
            ? AuthorizationUserDTO::createFromArray($authorizationUser) : null;
    }

    /**
     * @param Text $username
     *
     * @return bool
     */
    public function isUsernameTaken(Text $username): bool
    {
        $dbQuery = $this->db->prepare(<<<SQL
            SELECT
              1
            FROM
              users AS u
            WHERE
              u.username = :username
            LIMIT
              1
        SQL);

        $dbQuery->execute([
            'username' => $username->get(),
        ]);

        return !!$dbQuery->fetchColumn();
    }

    /**
     * @param RegisterCommand $cmd
     *
     * @return Id
     * @throws InvalidArgumentExceptionAbstract
     */
    public function register(RegisterCommand $cmd): Id
    {
        $dbQuery = $this->db->prepare(<<<SQL
            INSERT INTO 
              users (
                first_name,
                last_name,
                username,
                password
              )
            VALUES
              (
                :firstName,
                :lastName,
                :username,
                :password
              )
            RETURNING
              id
        SQL);

        $dbQuery->execute([
            'firstName' => $cmd->getFirstName()->get(),
            'lastName' => $cmd->getLastName()->get(),
            'username' => $cmd->getUsername()->get(),
            'password' => $cmd->getPassword()->get(),
        ]);

        return new Id($dbQuery->fetchColumn());
    }
}
