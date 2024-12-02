<?php

require('./../routes/routes.php');

$router = new Router();

// Define your routes
$router->get('/', function () {
    include PATH . 'index.php';
});
$router->post('/create', function () {
    include VALIDATOR . 'CreateFormRequest.php';
});

$router->dispatch();