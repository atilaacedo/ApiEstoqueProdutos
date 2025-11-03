<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController
{

    public function index()
    {
        $products = Product::all();

        return json_encode($products);
    }
    public function show($request)
    {
        $id = $request['params']['id'];
        $produto = Product::find($id);

        echo json_encode([
            "message" => "Produto encontrado com sucesso!",
            "produto" => $produto
        ]);
    }

    public function store($request)
    {
        $data = $request['data'];
        $newProduct = Product::create($data);

        return json_encode([
            'message' => 'Produto criado com sucesso',
            'produto' => $newProduct
        ]);
    }

    public function update($request)
    {
        $data = $request['data'];
        $id = $request['params']['id'];
        $updatedProduct = Product::update($id, $data);

        return json_encode([
            'message' => 'Produto atualizado com sucesso',
            'produto' => $updatedProduct
        ]);
    }

    public function destroy($request){
        $id = $request['params']['id'];
        $deleted = Product::delete($id);

        return json_encode([
            'message' => 'Produto deletado com sucesso',
            'deleted' => $deleted
        ]);
    }
}
