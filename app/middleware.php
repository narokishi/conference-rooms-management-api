<?php
declare(strict_types=1);

use App\Application\Middleware\ApiAuthorizationMiddleware;
use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');

    $app->add(SessionMiddleware::class);
    $app->add(new ApiAuthorizationMiddleware(
        $settings['apiKeys'] ?? []
    ));
};
