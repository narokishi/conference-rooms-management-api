<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\UserRepositoryInterface;
use Psr\Log\LoggerInterface;

abstract class UserAction extends Action
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @param LoggerInterface $logger
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        LoggerInterface $logger,
        UserRepositoryInterface $userRepository
    ) {
        parent::__construct($logger);

        $this->userRepository = $userRepository;
    }
}
