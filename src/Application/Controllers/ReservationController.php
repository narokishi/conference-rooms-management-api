<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\ConferenceRoom\Command\ConferenceRoomCreateCommand;
use App\Domain\ConferenceRoom\ConferenceRoomService;
use App\Domain\DomainException\AbstractDomainNotFoundException;
use App\Domain\DomainException\InvalidArgumentExceptionAbstract;
use App\Domain\Id;
use App\Domain\Reservation\Command\ReservationCreateCommand;
use App\Domain\Reservation\Exception\ReservationNotFoundException;
use App\Domain\Reservation\ReservationService;
use App\Domain\User\UserService;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Request;

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
     * @var UserService
     */
    private UserService $userService;

    /**
     * @var ConferenceRoomService
     */
    private ConferenceRoomService $conferenceRoomService;

    /**
     * ReservationController constructor.
     *
     * @param LoggerInterface $logger
     * @param ReservationService $reservationService
     * @param UserService $userService
     * @param ConferenceRoomService $conferenceRoomService
     */
    public function __construct(
        LoggerInterface $logger,
        ReservationService $reservationService,
        UserService $userService,
        ConferenceRoomService $conferenceRoomService
    ) {
        parent::__construct($logger);

        $this->reservationService = $reservationService;
        $this->userService = $userService;
        $this->conferenceRoomService = $conferenceRoomService;
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

    /**
     * @param Request $request
     *
     * @return MessageInterface
     * @throws HttpBadRequestException
     * @throws HttpNotFoundException
     * @throws InvalidArgumentExceptionAbstract
     */
    public function create(Request $request)
    {
        $cmd = ReservationCreateCommand::createFromPayload(
            $this->getPayload($request, [
                'userId',
                'conferenceRoomId',
                'startsAt',
                'endsAt',
            ])
        );

        try {
            $this->userService->findById($cmd->getUserId());
            $this->conferenceRoomService->findById($cmd->getConferenceRoomId());
        } catch (AbstractDomainNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }

        return $this->getJsonResponse(
            $this->reservationService->create($cmd)
        );
    }
}

