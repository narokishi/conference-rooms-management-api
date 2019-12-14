<?php
declare(strict_types=1);

namespace App\Domain\Reservation;

use App\Domain\Id;
use App\Domain\Reservation\DTO\ReservationDTO;
use App\Domain\Reservation\Exception\ReservationNotFoundException;
use App\Domain\Translation\Translation;

/**
 * Class ReservationService
 *
 * @package App\Domain\Reservation
 */
final class ReservationService
{
    /**
     * @var ReservationRepositoryInterface
     */
    private ReservationRepositoryInterface $reservationRepository;

    /**
     * @var Translation
     */
    private Translation $translation;

    /**
     * ReservationService constructor.
     *
     * @param ReservationRepositoryInterface $reservationRepository
     * @param Translation $translation
     */
    public function __construct(
        ReservationRepositoryInterface $reservationRepository,
        Translation $translation
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->translation = $translation;
    }

    /**
     * @param Id $reservationId
     *
     * @return ReservationDTO
     * @throws ReservationNotFoundException
     */
    public function findById(Id $reservationId): ReservationDTO
    {
        $reservation = $this->reservationRepository->findById($reservationId);

        if (empty($reservation)) {
            throw new ReservationNotFoundException(sprintf(
                $this->translation->get(ReservationNotFoundException::class),
                $reservationId->get()
            ));
        }

        return ReservationDTO::createFromArray($reservation);
    }
}
