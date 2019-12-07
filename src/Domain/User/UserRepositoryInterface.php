<?php
declare(strict_types=1);

namespace App\Domain\User;

/**
 * Interface UserRepositoryInterface
 *
 * @package App\Domain\User
 */
interface UserRepositoryInterface
{
    /**
     * @return UserDTOCollection
     */
    public function findAll(): UserDTOCollection;
}
