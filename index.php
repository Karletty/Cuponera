<?php
include_once 'Core/config.php';
include_once 'Core/error404.php';
include_once 'Core/error403.php';

session_start();

$url = $_SERVER['REQUEST_URI'];

$url = str_replace(PATH . '/', '', $url);
$url = explode('?', $url)[0];
$url = explode('/', $url);

$controller = (empty($url[0]) ? 'Offers' : $url[0]) . 'Controller';
$fileController = 'Controller/' . $controller . '.php';

if (!is_file($fileController)) {
      renderError404View();
      exit;
}

spl_autoload_register(function ($classname) {
      include_once 'Controller/' . $classname . '.php';
});

$contr = new $controller;
$method = empty($url[1]) ? "index" : $url[1];

if (!method_exists($contr, $method)) {
      renderError404View();
      exit;
}

$param = empty($url[2]) ? "" : $url[2];

$contr->$method($param);
