<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\DomainException\AbstractDomainNotFoundException;
use App\Domain\Id;

/**
 * Class UserNotFoundException
 *
 * @package App\Domain\User
 */
final class UserNotFoundException extends AbstractDomainNotFoundException
{
    /**
     * UserNotFoundException constructor.
     *
     * @param Id $userId
     */
    public function __construct(Id $userId)
    {
        parent::__construct("User (ID: {$userId->get()}) you requested does not exist.");
    }
}
