<?php
declare(strict_types=1);

namespace App\Application\Middleware\Exception;

use Slim\Exception\HttpUnauthorizedException;

/**
 * Class InvalidAuthorizationKeyException
 *
 * @package App\Application\Middleware\Exception
 */
final class InvalidAuthorizationKeyException extends HttpUnauthorizedException
{
}
