<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\AbstractAction;
use App\Domain\User\UserQueryRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractUserAction
 *
 * @package App\Application\Actions\User
 */
abstract class AbstractUserAction extends AbstractAction
{
    /**
     * @var UserQueryRepositoryInterface
     */
    protected UserQueryRepositoryInterface $userRepository;

    /**
     * @param LoggerInterface $logger
     * @param UserQueryRepositoryInterface $userRepository
     */
    public function __construct(
        LoggerInterface $logger,
        UserQueryRepositoryInterface $userRepository
    ) {
        parent::__construct($logger);

        $this->userRepository = $userRepository;
    }
}
