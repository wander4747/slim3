<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserEloquentRepository extends BaseEloquentRepository implements  UserRepositoryInterface
{
    public function entity()
    {
        return User::class;
    }
}