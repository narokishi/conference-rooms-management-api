<?php
declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Class ListUsersAction
 *
 * @package App\Application\Actions\User
 */
final class ListUsersUserAction extends AbstractUserAction
{
    /**
     * @return Response
     */
    protected function action(): Response
    {
        $users = $this->userRepository->findAll();

        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($users);
    }
}
