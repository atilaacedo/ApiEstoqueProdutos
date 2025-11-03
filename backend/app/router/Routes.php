<?php 

use App\Router\Router;

$router = new Router();

//Produto
$router->addRoute('GET','/produtos/{id}', 'ProductController@show');
$router->addRoute('GET','/produtos', 'ProductController@index');
$router->addRoute('POST','/produtos', 'ProductController@store');
$router->addRoute('PUT', '/produtos/{id}', 'ProductController@update');
$router->addRoute('DELETE','/produtos/{id}', 'ProductController@destroy');


return $router;
