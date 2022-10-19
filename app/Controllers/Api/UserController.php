<?php

namespace App\Controllers\Api;

use App\Services\UserService;
use Exception;
use Psr\Container\ContainerInterface;
use Slim\Http\StatusCode;

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
            return $response->withJson($users)->withStatus(StatusCode::HTTP_OK);
        } catch (Exception $e) {
            return $response->withJson(["error" => "There was an error displaying users"])->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function show($request, $response)
    {
        try {
            $id = $request->getAttribute('id');
            $user = $this->service->edit($id);

            if (!$user) {
                return $response->withJson(['message' => 'user not found'])->withStatus(StatusCode::HTTP_NOT_FOUND);
            }

            return $response->withJson($user)->withStatus(StatusCode::HTTP_OK);
        } catch (Exception $e) {
            return $response->withJson(["error" => "There was an error displaying user"])->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function store($request, $response)
    {
        try {
            $data = $request->getParsedBody();
            $user = $this->service->store($data);

            return $response->withJson($user)->withStatus(StatusCode::HTTP_CREATED);
        } catch (Exception $e) {
            return $response->withJson(["error" => "There was an error creating user"])->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function update($request, $response)
    {
        try {
            $id = $request->getAttribute('id');
            $data = $request->getParsedBody();
            $this->service->update($id, $data);

            return $response->withJson("")->withStatus(StatusCode::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return $response->withJson(["error" => "There was an error updating user"])->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function delete($request, $response)
    {
        try {
            $id = $request->getAttribute('id');
            $this->service->delete($id);

            return $response->withJson("")->withStatus(StatusCode::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return $response->withJson(["error" => "There was an error deleting user"])->withStatus(StatusCode::HTTP_BAD_REQUEST);
        }
    }
}