<?php
declare(strict_types=1);

namespace App\Domain\Authorization;

use App\Domain\Authorization\Command\RegisterCommand;
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
        $authId = $this->authorizationRepository->getAuthorizedUserId(
            $this->hashPassword($query)
        );

        if (!$authId instanceof Id) {
            throw new UnauthorizedCredentialsException();
        }

        return $authId;
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
            $this->hashPassword($cmd)
        );

        return $authId;
    }

    /**
     * @param PasswordableInterface $passwordable
     *
     * @return LoginQuery|RegisterCommand|PasswordableInterface
     */
    private function hashPassword(PasswordableInterface $passwordable): PasswordableInterface
    {
        return $passwordable->setPassword(new Text(
            $this->hasher->make($passwordable->getPassword()->get())
        ));
    }
}
