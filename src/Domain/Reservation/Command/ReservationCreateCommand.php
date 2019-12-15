<?php
declare(strict_types=1);

namespace App\Domain\Reservation\Command;

use App\Domain\DateTime;
use App\Domain\DomainException\InvalidArgumentExceptionAbstract;
use App\Domain\Id;

/**
 * Class ReservationCreateCommand
 *
 * @package App\Domain\Reservation\Command
 */
final class ReservationCreateCommand
{
    /**
     * @var Id
     */
    private Id $userId;

    /**
     * @var Id
     */
    private Id $conferenceRoomId;

    /**
     * @var DateTime
     */
    private DateTime $startsAt;

    /**
     * @var DateTime
     */
    private DateTime $endsAt;

    /**
     * @param array $payload
     *
     * @return self
     * @throws InvalidArgumentExceptionAbstract
     */
    public static function createFromPayload(array $payload): self
    {
        return (new self())
            ->setUserId(new Id($payload['userId']))
            ->setConferenceRoomId(new Id($payload['conferenceRoomId']))
            ->setStartsAt(new DateTime($payload['startsAt']))
            ->setEndsAt(new DateTime($payload['endsAt']));
    }

    /**
     * @return Id
     */
    public function getUserId(): Id
    {
        return $this->userId;
    }

    /**
     * @param Id $userId
     *
     * @return $this
     */
    public function setUserId(Id $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return Id
     */
    public function getConferenceRoomId(): Id
    {
        return $this->conferenceRoomId;
    }

    /**
     * @param Id $conferenceRoomId
     *
     * @return $this
     */
    public function setConferenceRoomId(Id $conferenceRoomId): self
    {
        $this->conferenceRoomId = $conferenceRoomId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartsAt(): DateTime
    {
        return $this->startsAt;
    }

    /**
     * @param DateTime $startsAt
     *
     * @return $this
     */
    public function setStartsAt(DateTime $startsAt): self
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndsAt(): DateTime
    {
        return $this->endsAt;
    }

    /**
     * @param DateTime $endsAt
     *
     * @return $this
     */
    public function setEndsAt(DateTime $endsAt): self
    {
        $this->endsAt = $endsAt;

        return $this;
    }
}
