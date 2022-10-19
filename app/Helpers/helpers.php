<?php

use Psr\Container\ContainerInterface;
use Slim\Http\Response;

function viewError(ContainerInterface $container,  Response $response,  $message)
{
    return $response->getBody()->write($container->get('renderer')->render('error.html', ['message' => $message]));
}