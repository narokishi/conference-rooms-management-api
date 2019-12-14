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
     * @var ReservationQueryRepositoryInterface
     */
    private ReservationQueryRepositoryInterface $queryRepository;

    /**
     * @var Translation
     */
    private Translation $translation;

    /**
     * ReservationService constructor.
     *
     * @param ReservationQueryRepositoryInterface $queryRepository
     * @param Translation $translation
     */
    public function __construct(
        ReservationQueryRepositoryInterface $queryRepository,
        Translation $translation
    ) {
        $this->queryRepository = $queryRepository;
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
        $reservation = $this->queryRepository->findById($reservationId);

        if (empty($reservation)) {
            throw new ReservationNotFoundException(sprintf(
                $this->translation->get(ReservationNotFoundException::class),
                $reservationId->get()
            ));
        }

        return ReservationDTO::createFromArray($reservation);
    }
}
