<?php
declare(strict_types=1);

namespace App\Domain\Authorization;

use App\Domain\Authorization\Hasher\HasherInterface;

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
}
