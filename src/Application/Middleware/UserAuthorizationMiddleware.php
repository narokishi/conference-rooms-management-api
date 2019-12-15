<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Middleware\Exception\InvalidAuthorizationKeyException;
use App\Application\Middleware\Exception\MissingAuthorizationHeaderException;
use App\Domain\Authorization\AuthorizationService;
use App\Domain\Authorization\Exception\ExpiredTokenException;
use App\Domain\Text;
use App\Domain\Translation\Translation;
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
     * @var Translation
     */
    private Translation $translation;

    /**
     * UserAuthorizationMiddleware constructor.
     *
     * @param AuthorizationService $authorizationService
     */
    public function __construct(
        AuthorizationService $authorizationService,
        Translation $translation
    ) {
        $this->authorizationService = $authorizationService;
        $this->translation = $translation;
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

        try {
            if (!$this->authorizationService->isValidToken(
                new Text($request->getHeader('X-Authorization-Token')[0])
            )) {
                throw new ExpiredTokenException(
                    $this->translation->get(ExpiredTokenException::class)
                );
            }
        } catch (ExpiredTokenException $e) {
            throw new InvalidAuthorizationKeyException($request, $e->getMessage());
        }

        return $handler->handle($request);
    }
}
