<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Middleware\Exception\InvalidAuthorizationKeyException;
use App\Application\Middleware\Exception\MissingAuthorizationHeaderException;
use App\Domain\Authorization\AuthorizationService;
use App\Domain\Text;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class UserAuthorizationMiddleware
 *
 * @package App\Application\Middleware
 */
final class UserAuthorizationMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthorizationService
     */
    private AuthorizationService $authorizationService;

    /**
     * UserAuthorizationMiddleware constructor.
     *
     * @param AuthorizationService $authorizationService
     */
    public function __construct(AuthorizationService $authorizationService)
    {
        $this->authorizationService = $authorizationService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws InvalidAuthorizationKeyException
     * @throws MissingAuthorizationHeaderException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('X-Authorization-Token')) {
            throw new MissingAuthorizationHeaderException($request);
        }

        if (!$this->authorizationService->isValidToken(
            new Text($request->getHeader('X-Authorization-Token')[0])
        )) {
            throw new InvalidAuthorizationKeyException($request);
        }

        return $handler->handle($request);
    }
}
