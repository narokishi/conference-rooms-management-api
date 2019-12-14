<?php
declare(strict_types=1);

namespace App\Domain\ConferenceRoom;

/**
 * Class ConferenceRoomDTO
 *
 * @package App\Domain\ConferenceRoom
 */
final class ConferenceRoomDTO implements \JsonSerializable
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
     * @var string
     */
    private string $createdAt;

    /**
     * @var string|null
     */
    private ?string $updatedAt;

    /**
     * ConferenceRoomDTO constructor.
     *
     * @param int $id
     * @param string $name
     * @param string $createdAt
     * @param string|null $updatedAt
     */
    public function __construct(int $id, string $name, string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array $conferenceRoom
     *
     * @return self
     */
    public static function createFromArray(array $conferenceRoom): self
    {
        return new self(
            $conferenceRoom['id'],
            $conferenceRoom['name'],
            $conferenceRoom['created_at'],
            $conferenceRoom['updated_at'],
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
