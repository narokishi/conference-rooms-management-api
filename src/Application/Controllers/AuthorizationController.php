<?php
declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Authorization\AuthorizationService;
use App\Domain\Authorization\Exception\UnauthorizedCredentialsException;
use App\Domain\Authorization\Query\LoginQuery;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Request;

/**
 * Class AuthorizationController
 *
 * @package App\Application\Controllers
 */
final class AuthorizationController extends AbstractController
{
    /**
     * @var AuthorizationService
     */
    private AuthorizationService $authorizationService;

    /**
     * AuthorizationController constructor.
     *
     * @param LoggerInterface $logger
     * @param AuthorizationService $authorizationService
     */
    public function __construct(
        LoggerInterface $logger,
        AuthorizationService $authorizationService
    ) {
        parent::__construct($logger);

        $this->authorizationService = $authorizationService;
    }

    /**
     * @param Request $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws HttpBadRequestException
     * @throws HttpUnauthorizedException
     */
    public function login(Request $request)
    {
        try {
            $this->authorizationService->login(
                LoginQuery::createFromPayload(
                    $this->getPayload($request, [
                        'username', 'password',
                    ])
                )
            );
        } catch (UnauthorizedCredentialsException $e) {
            throw new HttpUnauthorizedException($request);
        }

        return $this->getJsonResponse();
    }
}
