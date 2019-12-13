<?php
declare(strict_types=1);

namespace App\Domain\User\Exception;

use App\Domain\DomainException\AbstractDomainNotFoundException;
use App\Domain\Id;

/**
 * Class UserNotFoundException
 *
 * @package App\Domain\User\Exception
 */
final class UserNotFoundException extends AbstractDomainNotFoundException
{
}
