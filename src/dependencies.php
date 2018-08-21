<?php
// DIC configuration
use App\Controllers\VoucherController;
use App\Controllers\RecipientController;
use App\Controllers\SpecialofferController;

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
    return new VoucherController($c);
};

$container['RecipientController'] = function($c) {
    return new RecipientController($c);
};

$container['SpecialofferController'] = function($c) {
    return new SpecialofferController($c);
};