<?php

$container = $app->getContainer();

// Authentication
$container['auth'] = function () {
    return new App\Services\Authentication();
};

// Flash messages
$container['flash'] = function () {
    return new Slim\Flash\Messages();
};

// Twig
$container['view'] = function ($container) {
    $twig = new \Slim\Views\Twig(__DIR__ . '/../resources/views');
    $twig->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    // Add user as global variable
    $twig->getEnvironment()->addGlobal('auth', [
        'user' => $container->auth->getUser()
    ]);

    // Add flash messages as global variable
    $twig->getEnvironment()->addGlobal('flash', $container->flash->getMessages());

    return $twig;
};

// Validator
$container['validator'] = function () {
    return new App\Validation\Validator();
};