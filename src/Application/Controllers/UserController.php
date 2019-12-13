<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Common\Exception\AbstractCollectionException;
use App\Domain\Id;
use App\Domain\Translation\Translation;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserService;
use Psr\Http\Message\ResponseInterface;
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
     * @return ResponseInterface
     * @throws AbstractCollectionException
     */
    public function getAll(): ResponseInterface
    {
        return $this->getJsonResponse(
            $this->userService->findAll()
        );
    }

    /**
     * @param Id $userId
     *
     * @return ResponseInterface
     * @throws UserNotFoundException
     */
    public function getById(Id $userId)
    {
        return $this->getJsonResponse(
            $this->userService->findById($userId)
        );
    }
}

