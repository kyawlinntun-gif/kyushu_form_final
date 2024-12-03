<?php

class HomeController {
    public function index()
    {
        include VIEW . 'index.php';
    }
    public function create($router)
    {
        include VALIDATOR . 'CreateFormRequest.php';
    }
    public function store($router)
    {
        include MODEL . 'store.php';
    }
    public function confirm($router) 
    {
        // Not allow user to enter without form submit
        if($_SESSION['confirm']) {
            include VIEW . 'confirms/index.php';
        } else {
            $router->redirect('/');
        } 
    }
    public function complete()
    {
        include VIEW . 'complete.php';
    }
}