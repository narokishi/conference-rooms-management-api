<?php
declare(strict_types=1);

namespace App\Domain\Reservation;

use App\Domain\Id;
use App\Domain\Reservation\Command\ReservationCreateCommand;
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
     * @var ReservationCommandRepositoryInterface
     */
    private ReservationCommandRepositoryInterface $cmdRepository;

    /**
     * @var Translation
     */
    private Translation $translation;

    /**
     * ReservationService constructor.
     *
     * @param ReservationQueryRepositoryInterface $queryRepository
     * @param ReservationCommandRepositoryInterface $cmdRepository
     * @param Translation $translation
     */
    public function __construct(
        ReservationQueryRepositoryInterface $queryRepository,
        ReservationCommandRepositoryInterface $cmdRepository,
        Translation $translation
    ) {
        $this->queryRepository = $queryRepository;
        $this->cmdRepository = $cmdRepository;
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

    /**
     * @param ReservationCreateCommand $cmd
     *
     * @return Id
     */
    public function create(ReservationCreateCommand $cmd): Id
    {
        return $this->cmdRepository->create($cmd);
    }
}
