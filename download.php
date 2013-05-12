<?php

$file = $_GET['file'];

if (strpos($file, '..') !== FALSE || !file_exists("./files/$file")) {
    header('HTTP/1.0 404 Not Found');
    echo "Not found";
    die();
}

header('HTTP/1.0 302 Found');
header("Location: http://$_SERVER[SERVER_NAME]/files/$file");

$redis = new Redis();
$redis->connect('127.0.0.1');
$redis->incr("flvmeta:downloads:$file");
