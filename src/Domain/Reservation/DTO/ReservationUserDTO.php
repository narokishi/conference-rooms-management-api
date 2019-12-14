<?php
declare(strict_types=1);

namespace App\Domain\Reservation\DTO;

/**
 * Class ReservationUserDTO
 *
 * @package App\Domain\Reservation\DTO
 */
final class ReservationUserDTO implements \JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $fullName;

    /**
     * ReservationUserDTO constructor.
     *
     * @param int $id
     * @param string $fullName
     */
    public function __construct(
        int $id,
        string $fullName
    ) {
        $this->id = $id;
        $this->fullName = $fullName;
    }

    /**
     * @param array $reservationUser
     *
     * @return self
     */
    public static function createFromArray(array $reservationUser): self
    {
        return new self(
            $reservationUser['user_id'],
            $reservationUser['user_full_name']
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
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
