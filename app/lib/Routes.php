<?php

namespace App\Lib;

use App\Lib\Response;

class Routes
{
    private static $routes = [];

    public static function add($method, $endpoint, $callback): void
    {
        self::$routes[strtoupper($method)][self::normalizePath($endpoint)] = $callback;
    }

    public static function get($endpoint, $callback): void
    {
        self::add('GET', $endpoint, $callback);
    }

    public static function post($endpoint, $callback): void
    {
        self::add('POST', $endpoint, $callback);
    }

    public static function put($endpoint, $callback): void
    {
        self::add('PUT', $endpoint, $callback);
    }

    public static function delete($endpoint, $callback): void
    {
        self::add('DELETE', $endpoint, $callback);
    }

    public static function handleCors(): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    public static function dispatch(): void
    {
        self::handleCors(); 
    
        $requestedPath = self::normalizePath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $method = $_SERVER['REQUEST_METHOD'];
    
        if (!isset(self::$routes[$method])) {
            Response::methodNotAllowed();
            return;
        }
    
        foreach (self::$routes[$method] as $endpoint => $callback) {
            $params = self::matchRoute($endpoint, $requestedPath);
            if ($params !== false) {
                $requestData = [];
                if ($method === 'POST' || $method === 'PUT') {
                    $requestData = json_decode(file_get_contents("php://input"), true) ?? [];
                }
    
                if (is_callable($callback)) {
                    Response::success(call_user_func_array($callback, array_merge($params, [$requestData])));
                } elseif (is_array($callback) && count($callback) === 2) {
                    [$controller, $method] = $callback;
                    $controllerInstance = new $controller();
                    $response = call_user_func_array([$controllerInstance, $method], array_merge($params, [$requestData]));
                    Response::success($response);
                }
                return;
            }
        }
    
        Response::notFound();
    }
    

    private static function matchRoute($routePattern, $requestedPath)
    {
        $routeSegments = explode('/', self::normalizePath($routePattern));
        $requestedSegments = explode('/', $requestedPath);

        if (count($routeSegments) !== count($requestedSegments)) {
            return false;
        }

        $params = [];
        foreach ($routeSegments as $index => $segment) {
            if ($segment === $requestedSegments[$index]) {
                continue;
            } elseif (strpos($segment, '{') === 0 && strpos($segment, '}') === strlen($segment) - 1) {
                $params[] = $requestedSegments[$index];
            } else {
                return false;
            }
        }

        return $params;
    }

    private static function normalizePath($endpoint): string
    {
        return trim($endpoint, '/');
    }
    
}
