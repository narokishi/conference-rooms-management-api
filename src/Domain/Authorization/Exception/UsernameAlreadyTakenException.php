<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Exception;

use App\Domain\DomainException\AbstractDomainException;
use App\Domain\Text;

/**
 * Class UsernameAlreadyTakenException
 *
 * @package App\Domain\Authorization\Exception
 */
final class UsernameAlreadyTakenException extends AbstractDomainException
{
    public function __construct(Text $username)
    {
        parent::__construct(sprintf(
            'Username "%s" is already taken.',
            $username->get()
        ));
    }
}
