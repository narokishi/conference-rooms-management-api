<?php
declare(strict_types=1);

namespace App\Domain\Authorization;

use App\Domain\Authorization\Query\LoginQuery;
use App\Domain\Id;

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
     * @return bool
     */
    public function getAuthorizedUserId(LoginQuery $query): ?Id;
}
