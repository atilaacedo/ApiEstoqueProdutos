<?php 

use App\Router\Router;

$router = new Router();

//Produto
$router->addRoute('GET','/produtos/{id}', 'ProdutoController@show');
$router->addRoute('GET','/produtos', 'ProdutoController@index');
$router->addRoute('POST','/produtos', 'ProdutoController@store');
$router->addRoute('PUT', '/produtos/{id}', 'ProdutoController@update');
$router->addRoute('DELETE','/produtos/{id}', 'ProdutoController@destroy');


return $router;
