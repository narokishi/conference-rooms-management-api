<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Common\Exception\AbstractCollectionException;
use App\Domain\Id;

/**
 * Class UserService
 *
 * @package App\Domain\User
 */
final class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserDTOCollection
     * @throws AbstractCollectionException
     */
    public function findAll(): UserDTOCollection
    {
        return UserDTOCollection::createFromArray(
            array_map(
                fn($user) => UserDTO::createFromArray($user),
                $this->userRepository->findAll()
            )
        );
    }

    /**
     * @param Id $userId
     *
     * @return UserDTO
     * @throws UserNotFoundException
     */
    public function findById(Id $userId): UserDTO
    {
        $user = $this->userRepository->findById($userId);

        if (empty($user)) {
            throw new UserNotFoundException($userId);
        }

        return UserDTO::createFromArray($user);
    }
}
