<?php

use App\Controllers\Web\UserController as UserControllerWeb;
use App\Controllers\Api\UserController as UserControllerApi;
use Slim\App;

return function (App $app) {
    $app->group('', function(App $app) {
        $app->get('/', UserControllerWeb::class.':index');
        $app->get('/create', UserControllerWeb::class.':create');
        $app->post('/store', UserControllerWeb::class.':store');
        $app->get('/edit/{id}', UserControllerWeb::class.':edit');
        $app->put('/update/{id}', UserControllerWeb::class.':update');
        $app->get('/delete/{id}', UserControllerWeb::class.':delete');
    });

    $app->group('/api/users', function(App $app) {
        $app->get('', UserControllerApi::class.':index');
        $app->post('', UserControllerApi::class.':store');
        $app->get('/{id}', UserControllerApi::class.':show');
        $app->put('/{id}', UserControllerApi::class.':update');
        $app->delete('/{id}', UserControllerApi::class.':delete');
    });
};
