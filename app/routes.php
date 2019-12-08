<?php
declare(strict_types=1);

use App\Application\Controllers\UserController;
use App\Domain\Id;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use function App\route;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Conference Rooms Management Api is alive.');

        return $response;
    });

    $app->group('/api', function (Group $group) {
        $group->group('/v1', function (Group $group) {
            $group->group('/users', function (Group $group) {
                $group->get('/', route(UserController::class, 'getAll'));
                $group->get(
                    '/{userId:[1-9][0-9]*}',
                    fn ($request, $response, $args) => $group->getContainer()
                        ->get(UserController::class)
                        ->getById(
                            new Id((int) $args['userId'])
                        )
                );
            });
        });
    });
};
