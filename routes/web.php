<?php
require(ROUTES . 'routes.php');
require(CONTROLLER . 'HomeController.php');
$router = new Router();
$controller = new HomeController();
// Define your routes
$router->get('/', function () use ($controller) {
    $controller->index();
});
$router->post('/create', function () use ($router, $controller) {
    $controller->create($router);
});
$router->get('/confirm', function () use ($router, $controller) {   
    $controller->confirm($router);
});
$router->post('/store', function () use ($router, $controller) {
    $controller->store($router);
});
$router->get('/complete', function () use ($router, $controller) {
    $controller->complete($router);
});
$router->dispatch();