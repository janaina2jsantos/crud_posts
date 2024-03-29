<?php

define("SITE", "The City Times");
define("JS_VERSION", "1.0");

// db local
define("BASE_URL", "http://" . $_SERVER['SERVER_NAME'] . "/your_folder");
define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host"   => "###",
    "port"   => "###",
    "dbname" => "###",
    "username" => "###",
    "passwd"   => "###",
    "options"  => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

function url($uri): string
{
    if ($uri) {
        return BASE_URL . "/{$uri}";
    }
    return BASE_URL;
}

