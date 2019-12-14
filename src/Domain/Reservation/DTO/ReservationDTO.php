<?php
declare(strict_types=1);

namespace App\Domain\Reservation\DTO;

/**
 * Class ReservationDTO
 *
 * @package App\Domain\Reservation
 */
final class ReservationDTO implements \JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var ReservationUserDTO
     */
    private ReservationUserDTO $reservationUser;

    /**
     * @var ReservationConferenceRoomDTO
     */
    private ReservationConferenceRoomDTO $reservationConferenceRoom;

    /**
     * @var string
     */
    private string $startsAt;

    /**
     * @var string
     */
    private string $endsAt;

    /**
     * @var string
     */
    private string $createdAt;

    /**
     * @var string|null
     */
    private ?string $updatedAt;

    /**
     * ReservationDTO constructor.
     *
     * @param int $id
     * @param ReservationUserDTO $reservationUser
     * @param ReservationConferenceRoomDTO $reservationConferenceRoom
     * @param string $startsAt
     * @param string $endsAt
     * @param string $createdAt
     * @param string|null $updatedAt
     */
    public function __construct(
        int $id,
        ReservationUserDTO $reservationUser,
        ReservationConferenceRoomDTO $reservationConferenceRoom,
        string $startsAt,
        string $endsAt,
        string $createdAt,
        ?string $updatedAt
    ) {
        $this->id = $id;
        $this->reservationUser = $reservationUser;
        $this->reservationConferenceRoom = $reservationConferenceRoom;
        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array $reservation
     *
     * @return self
     */
    public static function createFromArray(array $reservation): self
    {
        return new self(
            $reservation['id'],
            ReservationUserDTO::createFromArray($reservation),
            ReservationConferenceRoomDTO::createFromArray($reservation),
            $reservation['starts_at'],
            $reservation['ends_at'],
            $reservation['created_at'],
            $reservation['updated_at'],
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return ReservationUserDTO
     */
    public function getReservationUser(): ReservationUserDTO
    {
        return $this->reservationUser;
    }

    /**
     * @return ReservationConferenceRoomDTO
     */
    public function getReservationConferenceRoom(): ReservationConferenceRoomDTO
    {
        return $this->reservationConferenceRoom;
    }

    /**
     * @return string
     */
    public function getStartsAt(): string
    {
        return $this->startsAt;
    }

    /**
     * @return string
     */
    public function getEndsAt(): string
    {
        return $this->endsAt;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
