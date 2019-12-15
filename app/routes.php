<?php
declare(strict_types=1);

use App\Application\Controllers\AuthorizationController;
use App\Application\Controllers\ConferenceRoomController;
use App\Application\Controllers\LanguageController;
use App\Application\Controllers\MigrationController;
use App\Application\Controllers\ReservationController;
use App\Application\Controllers\UserController;
use App\Application\Middleware\UserAuthorizationMiddleware;
use App\Domain\Id;
use App\Domain\Text;
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

    $app->group('/migrations', function (Group $group) {
        $group->post('/run-all', route(MigrationController::class, 'runAll'));
        $group->post('/down-all', route(MigrationController::class, 'downAll'));
    });

    $app->group('/api', function (Group $group) {
        $group->group('/v1', function (Group $group) {
            $group->group('/auth', function (Group $group) {
                $group->post('/login', route(AuthorizationController::class, 'login'));
                $group->post('/register', route(AuthorizationController::class, 'register'));
            });

            $group->group('/lang', function (Group $group) {
                $group->put(
                    '/{language:pl|en}',
                    fn ($request, $response, $args) => $group->getContainer()
                        ->get(LanguageController::class)
                        ->set(
                            new Text($args['language'])
                        )
                );
            });

            $group->group('', function (Group $group) {
                $group->group('/users', function (Group $group) {
                    $group->get('', route(UserController::class, 'getAll'));
                    $group->get(
                        '/{userId:[1-9][0-9]*}',
                        fn ($request, $response, $args) => $group->getContainer()
                            ->get(UserController::class)
                            ->getById(
                                new Id((int) $args['userId'])
                            )
                    );
                });

                $group->group('/conference-rooms', function (Group $group) {
                    $group->post('', route(ConferenceRoomController::class, 'create'));
                    $group->get(
                        '/{conferenceRoomId:[1-9][0-9]*}',
                        fn ($request, $response, $args) => $group->getContainer()
                            ->get(ConferenceRoomController::class)
                            ->getById(
                                new Id((int) $args['conferenceRoomId'])
                            )
                    );
                });

                $group->group('/reservations', function (Group $group) {
                    $group->post('', route(ReservationController::class, 'create'));
                    $group->get(
                        '/{reservationId:[1-9][0-9]*}',
                        fn ($request, $response, $args) => $group->getContainer()
                            ->get(ReservationController::class)
                            ->getById(
                                new Id((int) $args['reservationId'])
                            )
                    );
                });
            })->add(UserAuthorizationMiddleware::class);
        });
    });
};
