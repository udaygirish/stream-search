<?php

$request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);

if (file_exists(__DIR__ . '/' . $request_uri[0]) && $request_uri[0] != "/") {

   return false;

} else {

    $_SERVER['SCRIPT_NAME'] = '/index.php';

    include_once (__DIR__ . '/index.php');

}