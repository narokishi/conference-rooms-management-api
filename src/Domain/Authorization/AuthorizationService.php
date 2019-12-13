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
use App\Domain\Translation\Translation;

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
     * @var Translation
     */
    private $translation;

    /**
     * AuthorizationService constructor.
     *
     * @param HasherInterface $hasher
     * @param AuthorizationRepositoryInterface $authorizationRepository
     * @param Translation $translation
     */
    public function __construct(
        HasherInterface $hasher,
        AuthorizationRepositoryInterface $authorizationRepository,
        Translation $translation
    ) {
        $this->hasher = $hasher;
        $this->authorizationRepository = $authorizationRepository;
        $this->translation = $translation;
    }

    /**
     * @param LoginQuery $query
     *
     * @return Text
     * @throws UnauthorizedCredentialsException
     */
    public function login(LoginQuery $query): Text
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

        return $this->getTokenByAuthId($authUser->getId());
    }

    /**
     * @param RegisterCommand $cmd
     *
     * @return Text
     * @throws UsernameAlreadyTakenException
     */
    public function register(RegisterCommand $cmd): Text
    {
        if ($this->authorizationRepository->isUsernameTaken($cmd->getUsername())) {
            throw new UsernameAlreadyTakenException(sprintf(
                $this->translation->get(UsernameAlreadyTakenException::class),
                $cmd->getUsername()->get()
            ));
        }

        return $this->getTokenByAuthId(
            $this->authorizationRepository->register(
                $cmd->setPassword(new Text(
                    $this->hasher->make($cmd->getPassword()->get())
                ))
            )
        );
    }

    /**
     * @param Text $token
     *
     * @return bool
     */
    public function isValidToken(Text $token): bool
    {
        return $this->authorizationRepository->isValidToken($token);
    }

    /**
     * @param Id $authId
     *
     * @return Text
     */
    private function getTokenByAuthId(Id $authId): Text
    {
        $activeToken = $this->authorizationRepository->getActiveTokenByAuthId($authId);

        if ($activeToken instanceof Text) {
            return $activeToken;
        }

        return $this->authorizationRepository->generateToken($authId);
    }
}
