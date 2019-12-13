<?php
declare(strict_types=1);

namespace App\Domain\Authorization;

use App\Domain\Authorization\Command\RegisterCommand;
use App\Domain\Authorization\Query\LoginQuery;
use App\Domain\Id;
use App\Domain\Text;

/**
 * Interface AuthorizationRepositoryInterface
 *
 * @package App\Domain\Authorization
 */
interface AuthorizationRepositoryInterface
{
    /**
     * @param LoginQuery $query
     *
     * @return AuthorizationUserDTO|null
     */
    public function getAuthorizationUser(LoginQuery $query): ?AuthorizationUserDTO;

    /**
     * @param Text $username
     *
     * @return bool
     */
    public function isUsernameTaken(Text $username): bool;

    /**
     * @param RegisterCommand $cmd
     *
     * @return Id
     */
    public function register(RegisterCommand $cmd): Id;
}
