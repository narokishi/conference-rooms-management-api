<?php

namespace App\Domain\User;

/**
 * Class UserDTO
 *
 * @package App\Domain\User
 */
final class UserDTO
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $username;

    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * UserDTO constructor.
     *
     * @param int $id
     * @param string $username
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(int $id, string $username, string $firstName, string $lastName)
    {
        $this->id = $id;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
