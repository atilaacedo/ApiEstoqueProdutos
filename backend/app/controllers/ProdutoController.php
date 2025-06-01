<?php 

namespace App\Controllers;

class ProdutoController
{
    public function show($id)
    {
        // Simula a busca de um produto pelo ID
        $produto = [
            'id' => $id,
            'nome' => 'Produto Exemplo',
            'preco' => 99.99
        ];

        // Retorna o produto como JSON
        //header('Content-Type: application/json');
        echo json_encode($produto);
    }
}
