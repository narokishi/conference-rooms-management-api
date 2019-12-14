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
     * @var ConferenceRoomRepositoryInterface
     */
    private ConferenceRoomRepositoryInterface $conferenceRoomRepository;

    /**
     * @var Translation
     */
    private Translation $translation;

    /**
     * ConferenceRoomService constructor.
     *
     * @param ConferenceRoomRepositoryInterface $conferenceRoomRepository
     * @param Translation $translation
     */
    public function __construct(
        ConferenceRoomRepositoryInterface $conferenceRoomRepository,
        Translation $translation
    ) {
        $this->conferenceRoomRepository = $conferenceRoomRepository;
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
        $conferenceRoom = $this->conferenceRoomRepository->findById($conferenceRoomId);

        if (empty($conferenceRoom)) {
            throw new ConferenceRoomNotFoundException(sprintf(
                $this->translation->get(ConferenceRoomNotFoundException::class),
                $conferenceRoomId->get()
            ));
        }

        return ConferenceRoomDTO::createFromArray($conferenceRoom);
    }
}
