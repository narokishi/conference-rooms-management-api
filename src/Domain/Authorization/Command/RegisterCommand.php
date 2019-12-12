<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Command;

use App\Domain\Authorization\PasswordableInterface;
use App\Domain\Text;

/**
 * Class RegisterCommand
 *
 * @package App\Domain\Authorization\Command
 */
final class RegisterCommand implements PasswordableInterface
{
    /**
     * @var Text
     */
    private Text $firstName;

    /**
     * @var Text
     */
    private Text $lastName;

    /**
     * @var Text
     */
    private Text $username;

    /**
     * @var Text
     */
    private Text $password;

    /**
     * @param array $payload
     *
     * @return self
     */
    public static function createFromPayload(array $payload): self
    {
        return (new self())
            ->setFirstName(new Text($payload['firstName']))
            ->setLastName(new Text($payload['lastName']))
            ->setPassword(new Text($payload['password']))
            ->setUsername(new Text($payload['username']));
    }

    /**
     * @return Text
     */
    public function getFirstName(): Text
    {
        return $this->firstName;
    }

    /**
     * @param Text $firstName
     *
     * @return $this
     */
    public function setFirstName(Text $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return Text
     */
    public function getLastName(): Text
    {
        return $this->lastName;
    }

    /**
     * @param Text $lastName
     *
     * @return $this
     */
    public function setLastName(Text $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Text
     */
    public function getUsername(): Text
    {
        return $this->username;
    }

    /**
     * @param Text $username
     *
     * @return $this
     */
    public function setUsername(Text $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Text
     */
    public function getPassword(): Text
    {
        return $this->password;
    }

    /**
     * @param Text $password
     *
     * @return $this
     */
    public function setPassword(Text $password): self
    {
        $this->password = $password;

        return $this;
    }
}
