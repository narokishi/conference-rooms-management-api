<?php
declare(strict_types=1);

namespace App\Domain\ConferenceRoom;

use App\Domain\ConferenceRoom\Exception\ConferenceRoomNotFoundException;
use App\Domain\Id;
use App\Domain\Translation\Translation;

/**
 * Class ConferenceRoomService
 *
 * @package App\Domain\ConferenceRoom
 */
final class ConferenceRoomService
{
    /**
     * @var ConferenceRoomQueryRepositoryInterface
     */
    private ConferenceRoomQueryRepositoryInterface $queryRepository;

    /**
     * @var Translation
     */
    private Translation $translation;

    /**
     * ConferenceRoomService constructor.
     *
     * @param ConferenceRoomQueryRepositoryInterface $queryRepository
     * @param Translation $translation
     */
    public function __construct(
        ConferenceRoomQueryRepositoryInterface $queryRepository,
        Translation $translation
    ) {
        $this->queryRepository = $queryRepository;
        $this->translation = $translation;
    }


    /**
     * @param Id $conferenceRoomId
     *
     * @return ConferenceRoomDTO
     * @throws ConferenceRoomNotFoundException
     */
    public function findById(Id $conferenceRoomId): ConferenceRoomDTO
    {
        $conferenceRoom = $this->queryRepository->findById($conferenceRoomId);

        if (empty($conferenceRoom)) {
            throw new ConferenceRoomNotFoundException(sprintf(
                $this->translation->get(ConferenceRoomNotFoundException::class),
                $conferenceRoomId->get()
            ));
        }

        return ConferenceRoomDTO::createFromArray($conferenceRoom);
    }
}
