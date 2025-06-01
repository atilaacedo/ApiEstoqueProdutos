<?php

use App\Router\Router;

require 'bootstrap.php';


$method = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

$router = require '../app/router/Routes.php';

try{
    $router->dispatch($method, $uri);
}catch(Exception $e){
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'Internal Server Error',
        'message' => $e->getMessage()
    ]);
}
