<?php

define('VIEW_PATH', __DIR__ . '/view/');

function view($path, $options=[]) {
    extract($options);
    include VIEW_PATH . $path;
}