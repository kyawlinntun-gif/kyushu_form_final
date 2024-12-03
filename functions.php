<?php

function view($path, $options=[]) {
    extract($options);
    include VIEW_PATH . $path;
}
function prepareToStore($input){
    return htmlspecialchars(preg_replace('/\s+/', ' ', $input), ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5);
}
function normalize($input){
    return array_map('prepareToStore',$input);
}