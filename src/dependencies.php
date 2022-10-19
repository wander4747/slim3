<?php

use App\Controllers\Web\UserController as UserControllerWeb;
use App\Controllers\Api\UserController as UserControllerApi;
use App\Repositories\Eloquent\UserEloquentRepository;
use App\Services\UserService;
use Illuminate\Database\Capsule\Manager;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();
    $capsule = new Manager();
    $capsule->addConnection($container['settings'][$_ENV['KEY_DATABASE']]);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    // view renderer
    $container['renderer'] = function ($c) {
        $loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../templates');
        return new Twig\Environment($loader);
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

    $container['userRepository'] = function ($c) use ($capsule){
        return new UserEloquentRepository();
    };

    $container['userService'] = function ($c) use ($capsule){
        return new UserService($c->get('userRepository'));
    };

    $container[UserControllerWeb::class] = function ($c) {
        return new UserControllerWeb($c, $c->get('userService'));
    };

    $container[UserControllerApi::class] = function ($c) {
        return new UserControllerApi($c, $c->get('userService'));
    };
};
