<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Exception;

use App\Domain\DomainException\AbstractDomainException;

/**
 * Class UnauthorizedCredentialsException
 *
 * @package App\Domain\Authorization\Exception
 */
final class UnauthorizedCredentialsException extends AbstractDomainException
{
}
