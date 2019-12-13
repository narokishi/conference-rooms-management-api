<?php
declare(strict_types=1);

namespace App\Domain\Authorization;

use App\Domain\Authorization\Command\RegisterCommand;
use App\Domain\Authorization\DTO\AuthorizationUserDTO;
use App\Domain\Authorization\Exception\UnauthorizedCredentialsException;
use App\Domain\Authorization\Exception\UsernameAlreadyTakenException;
use App\Domain\Authorization\Hasher\HasherInterface;
use App\Domain\Authorization\Query\LoginQuery;
use App\Domain\Id;
use App\Domain\Text;

/**
 * Class AuthorizationService
 *
 * @package App\Domain\Authorization
 */
final class AuthorizationService
{
    /**
     * @var HasherInterface
     */
    private HasherInterface $hasher;

    /**
     * @var AuthorizationRepositoryInterface
     */
    private AuthorizationRepositoryInterface $authorizationRepository;

    /**
     * AuthorizationService constructor.
     *
     * @param HasherInterface $hasher
     * @param AuthorizationRepositoryInterface $authorizationRepository
     */
    public function __construct(
        HasherInterface $hasher,
        AuthorizationRepositoryInterface $authorizationRepository
    ) {
        $this->hasher = $hasher;
        $this->authorizationRepository = $authorizationRepository;
    }

    /**
     * @param LoginQuery $query
     *
     * @return Id
     * @throws UnauthorizedCredentialsException
     */
    public function login(LoginQuery $query): Id
    {
        $authUser = $this->authorizationRepository->getAuthorizationUser($query);

        if (!$authUser instanceof AuthorizationUserDTO) {
            throw new UnauthorizedCredentialsException();
        }

        if (!$this->hasher->check(
            $query->getPassword()->get(),
            $authUser->getHashedPassword()->get()
        )) {
            throw new UnauthorizedCredentialsException();
        }

        return $authUser->getId();
    }

    /**
     * @param RegisterCommand $cmd
     *
     * @return Id
     * @throws UsernameAlreadyTakenException
     */
    public function register(RegisterCommand $cmd): Id
    {
        if ($this->authorizationRepository->isUsernameTaken($cmd->getUsername())) {
            throw new UsernameAlreadyTakenException($cmd->getUsername());
        }

        $authId = $this->authorizationRepository->register(
            $cmd->setPassword(new Text(
                $this->hasher->make($cmd->getPassword()->get())
            ))
        );

        return $authId;
    }
}
