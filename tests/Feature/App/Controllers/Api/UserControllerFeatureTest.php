<?php

namespace Tests\Feature\App\Controllers\Api;

use App\Controllers\Api\UserController;
use App\Models\User;
use Slim\Http\StatusCode;
use Tests\BaseTest;

class UserControllerFeatureTest extends BaseTest
{
    public function testIndex()
    {
        $response = $this->runApp('GET', '/api/users');
        $this->assertEquals(StatusCode::HTTP_OK, $response->getStatusCode());
    }

    public function testStore()
    {
        $response = $this->runApp('POST', '/api/users', ['name' => 'Slim', 'email' => 'slim@slim.com']);
        $response->getBody();
        $this->assertEquals(StatusCode::HTTP_CREATED, $response->getStatusCode());
    }

    public function testShow()
    {
        $response = $this->runApp('GET', '/api/users/1');
        $this->assertEquals(StatusCode::HTTP_OK, $response->getStatusCode());
    }

    public function testUpdate()
    {
        $response = $this->runApp('PUT', '/api/users/1', ['name' => 'Slim', 'email' => 'slim@slim.com']);
        $this->assertEquals(StatusCode::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDelete()
    {
        $response = $this->runApp('DELETE', '/api/users/1');
        $this->assertEquals(StatusCode::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public static function tearDownAfterClass(): void
    {
        User::truncate();
    }
}