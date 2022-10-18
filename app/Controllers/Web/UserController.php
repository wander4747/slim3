<?php

namespace App\Controllers\Web;

use App\Services\UserService;

class UserController
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index($request, $response, $args)
    {
    }
}