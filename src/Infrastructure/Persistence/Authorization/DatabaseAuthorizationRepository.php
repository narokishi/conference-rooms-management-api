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

    /**
     * @param Text $token
     *
     * @return bool
     */
    public function isValidToken(Text $token): bool
    {
        $dbQuery = $this->db->prepare(<<<SQL
            UPDATE
              users_tokens
            SET
              expires_at = CURRENT_TIMESTAMP + INTERVAL '360 SECONDS'
            WHERE
              token = :token
              AND expires_at > CURRENT_TIMESTAMP
        SQL);

        $dbQuery->execute([
            'token' => $token->get(),
        ]);

        return $dbQuery->rowCount() > 0;
    }

    /**
     * @param Id $authId
     *
     * @return Text|null
     */
    public function getActiveTokenByAuthId(Id $authId): ?Text
    {
        $dbQuery = $this->db->prepare(<<<SQL
            UPDATE
              users_tokens
            SET
              expires_at = CURRENT_TIMESTAMP + INTERVAL '360 SECONDS'
            WHERE
              user_id = :authId
              AND expires_at > CURRENT_TIMESTAMP
            RETURNING
              token
        SQL);

        $dbQuery->execute([
            'authId' => $authId->get(),
        ]);

        return ($activeToken = $dbQuery->fetchColumn())
            ? new Text($activeToken) : null;
    }

    /**
     * @param Id $authId
     *
     * @return Text
     */
    public function generateToken(Id $authId): Text
    {
        do {
            $dbQuery = $this->db->prepare(<<<SQL
                SELECT
                  1
                FROM
                  users_tokens AS ut
                WHERE
                  ut.token = :token
        SQL);

            $token = md5(uniqid((string) rand(), true));
            $dbQuery->execute([
                'token' => $token,
            ]);
        } while (!!$dbQuery->fetchColumn());

        $dbQuery = $this->db->prepare(<<<SQL
            INSERT INTO
              users_tokens (
                user_id,
                token,
                expires_at
              )
            VALUES
              (
                 :authId,
                 :token,
                 CURRENT_TIMESTAMP + INTERVAL '360 SECONDS'
              )
        SQL);

        $dbQuery->execute([
            'authId' => $authId->get(),
            'token' => $token,
        ]);

        return new Text($token);
    }
}
