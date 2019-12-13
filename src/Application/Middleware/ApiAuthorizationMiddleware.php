<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Middleware\Exception\InvalidAuthorizationKeyException;
use App\Application\Middleware\Exception\MissingAuthorizationHeaderException;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class ApiAuthorizationMiddleware
 *
 * @package App\Application\Middleware
 */
final class ApiAuthorizationMiddleware implements Middleware
{
    /**
     * @var array
     */
    private array $apiKeys;

    /**
     * ApiAuthorizationMiddleware constructor.
     *
     * @param array $apiKeys
     */
    public function __construct(array $apiKeys)
    {
        $this->apiKeys = $apiKeys;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws MissingAuthorizationHeaderException
     * @throws InvalidAuthorizationKeyException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!$request->hasHeader('Authorization')) {
            throw new MissingAuthorizationHeaderException($request);
        }

        if (!in_array($request->getHeader('Authorization')[0], $this->apiKeys)) {
            throw new InvalidAuthorizationKeyException($request);
        }

        return $handler->handle($request);
    }
}
