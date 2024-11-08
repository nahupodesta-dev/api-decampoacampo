<?php
use App\Lib\Routes;
use App\Controllers\ProductController;

$controller = new ProductController();

Routes::get('/productos', [$controller, 'index']);
Routes::get('/productos/{id}', [$controller, 'show']);
Routes::post('/productos', [$controller, 'store']);
Routes::put('/productos/{id}', [$controller, 'update']);
Routes::delete('/productos/{id}', [$controller, 'destroy']);