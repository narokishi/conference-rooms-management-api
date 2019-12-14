<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Id;
use App\Domain\Reservation\Exception\ReservationNotFoundException;
use App\Domain\Reservation\ReservationService;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ReservationController
 *
 * @package App\Application\Controllers
 */
final class ReservationController extends AbstractController
{
    /**
     * @var ReservationService
     */
    private ReservationService $reservationService;

    /**
     * @param LoggerInterface $logger
     * @param ReservationService $reservationService
     */
    public function __construct(
        LoggerInterface $logger,
        ReservationService $reservationService
    ) {
        parent::__construct($logger);

        $this->reservationService = $reservationService;
    }

    /**
     * @param Id $reservationId
     *
     * @return MessageInterface
     * @throws ReservationNotFoundException
     */
    public function getById(Id $reservationId): MessageInterface
    {
        return $this->getJsonResponse(
            $this->reservationService->findById($reservationId)
        );
    }
}

