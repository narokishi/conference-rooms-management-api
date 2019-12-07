<?php
declare(strict_types=1);

namespace App\Domain\User;

/**
 * Interface UserRepository
 *
 * @package App\Domain\User
 */
interface UserRepository
{
    /**
     * @return UserDTOCollection
     */
    public function findAll(): UserDTOCollection;
}
