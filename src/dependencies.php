<?php

use App\Controllers\Web\UserController;
use App\Repositories\Eloquent\UserEloquentRepository;
use App\Services\UserService;
use Illuminate\Database\Capsule\Manager;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();
    $capsule = new Manager();
    $capsule->addConnection($container['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();


    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container['db'] = function ($c) use ($capsule){
        return $capsule;
    };

    $container[UserController::class] = function ($c) {
        return new UserController(new UserService(new UserEloquentRepository()));
    };

    $container[UserService::class] = function ($c) {
        return new UserService(new UserEloquentRepository());
    };
};
