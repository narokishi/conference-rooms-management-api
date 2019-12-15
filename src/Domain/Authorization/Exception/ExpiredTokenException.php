<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Exception;

use App\Domain\DomainException\AbstractDomainException;

/**
 * Class ExpiredTokenException
 *
 * @package App\Domain\Authorization\Exception
 */
final class ExpiredTokenException extends AbstractDomainException
{
}
