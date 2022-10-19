<?php

namespace App\Controllers\Web;

use App\Services\UserService;
use Exception;
use Psr\Container\ContainerInterface;

class UserController
{
    /**
     * @var UserService
     */

    private $service;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container, UserService $service)
    {
        $this->service = $service;
        $this->container = $container;
    }

    public function index($request, $response, $args)
    {
        try {
            $users = $this->service->all();
            $response->getBody()->write($this->container->get('renderer')->render('users/index.html', ['users' => $users]));
        } catch (Exception $e) {
            viewError($this->container, $response, $e->getMessage());
        }
    }
}