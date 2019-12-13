<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Common\Exception\AbstractCollectionException;
use App\Domain\Id;
use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\UserService;
use Psr\Http\Message\MessageInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UserController
 *
 * @package App\Application\Controllers
 */
final class UserController extends AbstractController
{
    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @param LoggerInterface $logger
     * @param UserService $userService
     */
    public function __construct(
        LoggerInterface $logger,
        UserService $userService
    ) {
        parent::__construct($logger);

        $this->userService = $userService;
    }

    /**
     * @return MessageInterface
     * @throws AbstractCollectionException
     */
    public function getAll(): MessageInterface
    {
        return $this->getJsonResponse(
            $this->userService->findAll()
        );
    }

    /**
     * @param Id $userId
     *
     * @return MessageInterface
     * @throws UserNotFoundException
     */
    public function getById(Id $userId): MessageInterface
    {
        return $this->getJsonResponse(
            $this->userService->findById($userId)
        );
    }
}

