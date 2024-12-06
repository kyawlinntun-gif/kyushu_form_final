<?php
session_start();
require('./../env.php');
function view($path, $options=[]) {
    extract($options);
    include VIEW_PATH . $path;
}
require('./../routes/web.php');

