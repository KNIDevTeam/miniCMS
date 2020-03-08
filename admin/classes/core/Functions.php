<?php
function asset($path) {
    return call_user_func($GLOBALS['_asset_handler'], $path);
}

function crsf() {
    return call_user_func($GLOBALS['_crsf_handler']);
}

function ajaxCrsf() {
    return call_user_func($GLOBALS['_ajax_crsf_handler']);
}

function redirect($path) {
    return call_user_func($GLOBALS['_redirect_handler'], $path);
}

function abort($codeNum) {
    return call_user_func($GLOBALS['_abort_handler'], $codeNum);
}

function route($routeName) {
    return call_user_func($GLOBALS['_route_handler'], $routeName);
}
