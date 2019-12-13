<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Exception;

use App\Domain\DomainException\AbstractDomainException;

/**
 * Class UsernameAlreadyTakenException
 *
 * @package App\Domain\Authorization\Exception
 */
final class UsernameAlreadyTakenException extends AbstractDomainException
{
}
