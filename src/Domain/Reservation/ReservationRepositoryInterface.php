<?php
declare(strict_types=1);

namespace App\Domain\Reservation;

use App\Domain\Id;

/**
 * Interface ReservationRepositoryInterface
 *
 * @package App\Domain\Reservation
 */
interface ReservationRepositoryInterface
{
    /**
     * @param Id $reservationId
     *
     * @return array|null
     */
    public function findById(Id $reservationId): ?array;
}
