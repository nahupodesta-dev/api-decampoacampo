<?php

namespace App\Controllers;

use App\Lib\Response;
use App\Models\Product;

class ProductController 
{
    private function calculatePriceInUSD($priceInPesos)
    {
        return round($priceInPesos / PRECIO_USD, 2);
    }
    public function index()
    {
        $products = Product::all();

        $products = array_map(function($product) {
            $product['precio_usd'] = $this->calculatePriceInUSD($product['precio']);
            return $product;
        }, $products);

        Response::success($products);
    }

    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            Response::notFound("Producto no encontrado");
        } 

        $product['precio_usd'] = $this->calculatePriceInUSD($product['precio']);
        Response::success($product);
    }

    public function store($request)
    {
        if (!isset($request['nombre']) || !isset($request['descripcion']) || !isset($request['precio'])) {
            Response::error("Datos incompletos para crear el producto", 400);
            return;
        }

        try {
            $id = Product::create([
                'nombre' => htmlspecialchars($request['nombre']),
                'descripcion' => htmlspecialchars($request['descripcion']),
                'precio' => (float)$request['precio']
            ]);
            Response::success(["message" => "Producto creado", "id" => $id]);
        } catch (\Exception $e) {
            echo 'entre aca';
            Response::error("Error al crear el producto: " . $e->getMessage());
        }
    }

    public function update($id, $request)
    {
        if (!isset($request['nombre']) || !isset($request['descripcion']) || !isset($request['precio'])) {
            Response::error("Datos incompletos para actualizar el producto", 400);
            return;
        }

        try {
            if (Product::update($id, [
                'nombre' => htmlspecialchars($request['nombre']),
                'descripcion' => htmlspecialchars($request['descripcion']),
                'precio' => (float)$request['precio']
            ])) {
                Response::success(["message" => "Producto actualizado"]);
            } else {
                Response::notFound("Producto no encontrado");
            }
        } catch (\Exception $e) {
            Response::error("Error al actualizar el producto: " . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if (!Product::delete($id)) {
                Response::notFound("Producto no encontrado");
            }
            Response::success(["message" => "Producto eliminado"]);
        } catch (\Exception $e) {
            Response::error("Error al eliminar el producto: " . $e->getMessage());
        }
    }
}