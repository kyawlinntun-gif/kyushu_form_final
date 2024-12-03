<?php

function view($path, $options=[]) {
    extract($options);
    include VIEW_PATH . $path;
}
