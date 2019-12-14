<?php
declare(strict_types=1);

namespace App\Domain\Reservation\Exception;

use App\Domain\DomainException\AbstractDomainNotFoundException;

/**
 * Class ReservationNotFoundException
 *
 * @package App\Domain\Reservation\Exception
 */
final class ReservationNotFoundException extends AbstractDomainNotFoundException
{
}
