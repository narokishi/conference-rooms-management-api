<?php
declare(strict_types=1);

namespace App\Domain\Authorization\DTO;

use App\Domain\DomainException\InvalidArgumentExceptionAbstract;
use App\Domain\Id;
use App\Domain\Text;

/**
 * Class AuthorizationUserDTO
 *
 * @package App\Domain\Authorization
 */
final class AuthorizationUserDTO
{
    /**
     * @var Id
     */
    private Id $id;

    /**
     * @var Text
     */
    private Text $hashedPassword;

    /**
     * @var Text
     */
    private Text $username;

    /**
     * AuthorizationUserDTO constructor.
     *
     * @param Id $id
     * @param Text $hashedPassword
     * @param Text $username
     */
    public function __construct(Id $id, Text $hashedPassword, Text $username)
    {
        $this->id = $id;
        $this->hashedPassword = $hashedPassword;
        $this->username = $username;
    }

    /**
     * @param array $authorizationUser
     *
     * @return self
     * @throws InvalidArgumentExceptionAbstract
     */
    public static function createFromArray(array $authorizationUser): self
    {
        return new self(
            new Id($authorizationUser['id']),
            new Text($authorizationUser['password']),
            new Text($authorizationUser['username'])
        );
    }

    /**
     * @return Id
     */
    public function getId(): Id
    {
        return $this->id;
    }

    /**
     * @return Text
     */
    public function getHashedPassword(): Text
    {
        return $this->hashedPassword;
    }

    /**
     * @return Text
     */
    public function getUsername(): Text
    {
        return $this->username;
    }
}
