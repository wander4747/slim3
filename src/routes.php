<?php

use App\Controllers\Web\UserController;
use Slim\App;

return function (App $app) {
    $app->group('', function(App $app) {
        $app->get('/', UserController::class.':index');
    });
};
