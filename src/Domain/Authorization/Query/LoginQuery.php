<?php
declare(strict_types=1);

namespace App\Domain\Authorization\Query;

use App\Domain\Text;

/**
 * Class LoginQuery
 *
 * @package App\Domain\Authorization\Query
 */
final class LoginQuery
{
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
            ->setPassword(new Text($payload['password']))
            ->setUsername(new Text($payload['username']));
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
