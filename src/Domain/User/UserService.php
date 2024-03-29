<?php
declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Common\Exception\AbstractCollectionException;
use App\Domain\Id;
use App\Domain\Translation\Translation;
use App\Domain\User\Exception\UserNotFoundException;

/**
 * Class UserService
 *
 * @package App\Domain\User
 */
final class UserService
{
    /**
     * @var UserQueryRepositoryInterface
     */
    private UserQueryRepositoryInterface $userRepository;

    /**
     * @var Translation
     */
    private Translation $translation;

    /**
     * UserService constructor.
     *
     * @param UserQueryRepositoryInterface $userRepository
     * @param Translation $translation
     */
    public function __construct(
        UserQueryRepositoryInterface $userRepository,
        Translation $translation
    ) {
        $this->userRepository = $userRepository;
        $this->translation = $translation;
    }

    /**
     * @return UserDTOCollection
     * @throws AbstractCollectionException
     */
    public function findAll(): UserDTOCollection
    {
        return UserDTOCollection::createFromArray(
            array_map(
                fn(array $user) => UserDTO::createFromArray($user),
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
            throw new UserNotFoundException(sprintf(
                $this->translation->get(UserNotFoundException::class),
                $userId->get()
            ));
        }

        return UserDTO::createFromArray($user);
    }
}
