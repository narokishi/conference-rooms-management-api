<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Conference Rooms Management Api is alive.');

        return $response;
    });

    $app->group('/api', function (Group $group) {
        $group->group('/v1', function (Group $group) {
            $group->group('/users', function (Group $group) {
                $group->get('', ListUsersAction::class);
            });
        });
    });
};
