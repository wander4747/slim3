<?php

use Psr\Container\ContainerInterface;
use Slim\Http\Response;

function viewError(ContainerInterface $container, Response $response, $message, $exception = "")
{
    if (!empty($exception))
        $container->get('logger')->error($exception);

    return $response->getBody()->write($container->get('renderer')->render('error.html', ['message' => $message]));
}