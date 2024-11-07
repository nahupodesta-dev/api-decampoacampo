<?php

namespace App\Lib;

use App\Lib\Response;

class Routes
{
    private static $routes = [];

    public static function get($endpoint, $callback): void
    {
        self::$routes['GET'][self::normalizePath($endpoint)] = $callback;
    }

    public static function post($endpoint, $callback): void
    {
        self::$routes['POST'][self::normalizePath($endpoint)] = $callback;
    }

    public static function put($endpoint, $callback): void
    {
        self::$routes['PUT'][self::normalizePath($endpoint)] = $callback;
    }

    public static function delete($endpoint, $callback): void
    {
        self::$routes['DELETE'][self::normalizePath($endpoint)] = $callback;
    }

    public static function dispatch(): void
    {
        $requestedPath = self::normalizePath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset(self::$routes[$method])) {
            Response::methodNotAllowed();
            return;
        }

        foreach (self::$routes[$method] as $endpoint => $callback) {
            if ($endpoint === $requestedPath) { 
                if (is_callable($callback)) {
                    Response::success(call_user_func($callback));
                } elseif (is_array($callback) && count($callback) === 2) {
                    [$controller, $method] = $callback;
                    $controllerInstance = new $controller();
                    $response = $controllerInstance->$method();

                    Response::success($response);
                }
                return;
            }
        }

        Response::notFound();
    }

    private static function normalizePath($endpoint): string
    {   
        return trim($endpoint, '/');
    }
}