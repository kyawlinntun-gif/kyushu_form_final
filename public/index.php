<?php
session_start();
define('VIEW', __DIR__ . '/../view/');
define('VALIDATOR', __DIR__ . '/../validator/');
define('ROUTES', __DIR__ . '/../routes/');
define('MODEL', __DIR__ . '/../model/');
require('./../functions.php');
require('./../routes/web.php');

