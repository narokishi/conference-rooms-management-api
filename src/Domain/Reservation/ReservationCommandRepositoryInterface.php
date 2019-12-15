<?php
declare(strict_types=1);

namespace App\Domain\Reservation;

use App\Domain\Id;
use App\Domain\Reservation\Command\ReservationCreateCommand;

/**
 * Interface ReservationCommandRepositoryInterface
 *
 * @package App\Domain\Reservation
 */
interface ReservationCommandRepositoryInterface
{
    /**
     * @param ReservationCreateCommand $cmd
     *
     * @return Id
     */
    public function create(ReservationCreateCommand $cmd): Id;
}
