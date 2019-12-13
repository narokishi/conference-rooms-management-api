<?php
declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\Translation\Translation;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Class LanguageMiddleware
 *
 * @package App\Application\Middleware
 */
final class LanguageMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($request->hasHeader('X-Language')) {
            $language = $request->getHeader('X-Language')[0];

            if (in_array($language, array_keys(Translation::$languages))) {
                Translation::setLanguage($language, true);
            }
        }

        return $handler->handle($request);
    }
}
