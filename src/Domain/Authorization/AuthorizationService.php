<?php
declare(strict_types=1);

namespace App\Domain\Authorization;

use App\Domain\Authorization\Exception\UnauthorizedCredentialsException;
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
     * @throws UnauthorizedCredentialsException
     */
    public function login(LoginQuery $query)
    {
        $authId = $this->authorizationRepository->getAuthorizedUserId(
            $query->setPassword(new Text(
                $this->hasher->make($query->getPassword()->get())
            ))
        );

        if (!$authId instanceof Id) {
            throw new UnauthorizedCredentialsException();
        }
    }
}
