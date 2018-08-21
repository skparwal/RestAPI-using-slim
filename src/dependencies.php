<?php
// DIC configuration
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('templates');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

$container['VoucherController'] = function($c) {
    return new App\Controllers\VoucherController($c);
};

$container['RecipientController'] = function($c) {
    return new App\Controllers\RecipientController($c);
};

$container['SpecialofferController'] = function($c) {
    return new App\Controllers\SpecialofferController($c);
};