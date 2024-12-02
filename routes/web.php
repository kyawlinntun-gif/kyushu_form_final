<?php

require(ROUTES . 'routes.php');
$router = new Router();
// Define your routes
$router->get('/', function () {
    include VIEW . 'index.php';
});
$router->post('/create', function () use ($router) {
    include VALIDATOR . 'createFormRequest.php';
});
$router->get('/confirm', function () use ($router) {
    // Not allow user to enter without form submit
    if($_SESSION['confirm']) {
        include VIEW . 'confirms/index.php';
    } else {
        $router->redirect('/');
    }    
});
$router->post('/store', function () {
    include MODEL . 'store.php';
});
$router->post('/complete', function() {
    include VIEW . 'complete.php';
});
$router->dispatch();