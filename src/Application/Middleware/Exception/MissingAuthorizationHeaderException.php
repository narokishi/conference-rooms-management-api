<?php
declare(strict_types=1);

namespace App\Application\Middleware\Exception;

use Slim\Exception\HttpUnauthorizedException;

/**
 * Class MissingAuthorizationHeaderException
 *
 * @package App\Application\Middleware\Exception
 */
final class MissingAuthorizationHeaderException extends HttpUnauthorizedException
{
}
