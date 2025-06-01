<?php 

use App\Router\Router;

$router = new Router();

//Produto
$router->addRoute('GET','/produtos/{id}', 'ProdutoController@show');
$router->addRoute('POST','/produtos', 'ProdutoController@store');
$router->addRoute('DELETE','/produtos', 'ProdutoController@destroy');


return $router;
