<?php

namespace App\Domain\User;

use App\Domain\Common\AbstractCommonCollection;

/**
 * Class UserDTOCollection
 *
 * @package App\Domain\User
 */
final class UserDTOCollection extends AbstractCommonCollection
{
    /**
     * @return string
     */
    protected function getCollectionType(): string
    {
        return UserDTO::class;
    }
}
