<?php

spl_autoload_register(function ($class) {

    $path = str_replace('App\\', '', $class);
    $pathParts = explode('\\', $path);

    $pathParts = array_map(function($part, $index) use ($pathParts) {
        return $index < count($pathParts) - 1 ? strtolower($part) : $part;
    }, $pathParts, array_keys($pathParts));

    $ruta = __DIR__ . '/app/' . implode('/', $pathParts) . '.php';

    if (file_exists($ruta)) {
        require_once $ruta;
    } else {
        die("No se pudo cargar la clase {$class} en la ruta {$ruta}");
    }
});