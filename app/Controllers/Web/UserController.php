<?php

namespace App\Controllers\Web;

use App\Models\User;
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