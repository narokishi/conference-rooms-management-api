<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Id;

/**
 * Interface UserQueryRepositoryInterface
 *
 * @package App\Domain\User
 */
interface UserQueryRepositoryInterface
{
    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param Id $userId
     *
     * @return array|null
     */
    public function findById(Id $userId): ?array;
}
