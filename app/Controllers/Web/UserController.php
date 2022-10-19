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
            viewError($this->container, $response, "Ocorreu um erro ao listar os usuários",$e->getMessage());
        }
    }

    public function create($request, $response)
    {
        $response->getBody()->write($this->container->get('renderer')->render('users/create.html', ["title" => "Cadastro de usuário"]));
    }

    public function store($request, $response)
    {
        try {
            $data = $request->getParsedBody();
            $this->service->store($data);
            return $response->withHeader('Location', '/');
        } catch (Exception $e) {
            viewError($this->container, $response, "Ocorreu um erro ao salvar o usuário", $e->getMessage());
        }
    }

    public function edit($request, $response)
    {
        $id = $request->getAttribute('id');
        $user = $this->service->edit($id);

        if (!$user) {
            return $response->withHeader('Location', '/')->withStatus(302);
        }

        $response->getBody()->write($this->container->get('renderer')->render('users/update.html', [
            "title" => "Editar usuário",
            "user" => $user
        ]));
    }

    public function update($request, $response)
    {
        try {
            $id = $request->getAttribute('id');
            $data = $request->getParsedBody();
            $this->service->update($id, $data);

            return $response->withHeader('Location', "/");
        } catch (Exception $e) {
            viewError($this->container, $response, "Ocorreu um erro ao atualizar o usuário", $e->getMessage());
        }
    }

    public function delete($request, $response)
    {
        try {
            $id = $request->getAttribute('id');
            $this->service->delete($id);
            return $response->withHeader('Location', "/");
        } catch (Exception $e) {
            viewError($this->container, $response, "Ocorreu um erro ao deletar o usuário", $e->getMessage());
        }
    }
}