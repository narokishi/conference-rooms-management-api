<?php
declare(strict_types=1);

namespace App\Domain\Reservation\DTO;

/**
 * Class ReservationUserDTO
 *
 * @package App\Domain\Reservation\DTO
 */
final class ReservationConferenceRoomDTO implements \JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * ReservationUserDTO constructor.
     *
     * @param int $id
     * @param string $name
     */
    public function __construct(
        int $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param array $reservationConferenceRoom
     *
     * @return static
     */
    public static function createFromArray(array $reservationConferenceRoom): self
    {
        return new self(
            $reservationConferenceRoom['conference_room_id'],
            $reservationConferenceRoom['conference_room_name']
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
