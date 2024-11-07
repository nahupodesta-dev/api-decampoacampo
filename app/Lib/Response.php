<?php

namespace App\Lib;

class Response
{
    const HTTP_OK = 200;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;

    public static function json($data, int $statusCode = self::HTTP_OK): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        if (!is_array($data) && !is_object($data)) {
            $data = ["message" => $data];
        }

        echo json_encode($data);
        exit(); 
    }

    public static function success($data): void
    {
        self::json($data, self::HTTP_OK);
    }

    public static function error($message, int $statusCode = self::HTTP_BAD_REQUEST): void
    {
        self::json(["error" => $message], $statusCode);
    }

    public static function notFound($message = "Ruta no encontrada"): void
    {
        self::error($message, self::HTTP_NOT_FOUND);
    }

    public static function methodNotAllowed($message = "Método no permitido"): void
    {
        self::error($message, self::HTTP_METHOD_NOT_ALLOWED);
    }
}
