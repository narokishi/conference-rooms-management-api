<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\ConferenceRoom\Command\ConferenceRoomCreateCommand;
use App\Domain\ConferenceRoom\ConferenceRoomService;
use App\Domain\ConferenceRoom\Exception\ConferenceRoomNotFoundException;
use App\Domain\Id;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Psr7\Request;

/**
 * Class ConferenceRoomController
 *
 * @package App\Application\Controllers
 */
final class ConferenceRoomController extends AbstractController
{
    /**
     * @var ConferenceRoomService
     */
    private ConferenceRoomService $conferenceRoomService;

    /**
     * @param LoggerInterface $logger
     * @param ConferenceRoomService $conferenceRoomService
     */
    public function __construct(
        LoggerInterface $logger,
        ConferenceRoomService $conferenceRoomService
    ) {
        parent::__construct($logger);

        $this->conferenceRoomService = $conferenceRoomService;
    }

    /**
     * @param Id $conferenceRoomId
     *
     * @return MessageInterface
     * @throws ConferenceRoomNotFoundException
     */
    public function getById(Id $conferenceRoomId): MessageInterface
    {
        return $this->getJsonResponse(
            $this->conferenceRoomService->findById($conferenceRoomId)
        );
    }

    /**
     * @param Request $request
     *
     * @return MessageInterface
     * @throws HttpBadRequestException
     */
    public function create(Request $request)
    {
        return $this->getJsonResponse(
            $this->conferenceRoomService->create(
                ConferenceRoomCreateCommand::createFromPayload(
                    $this->getPayload($request, [
                        'name',
                    ])
                )
            )
        );
    }
}

