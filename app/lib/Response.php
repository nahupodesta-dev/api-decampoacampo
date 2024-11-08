<?php

namespace App\Lib;

class Response
{
    const HTTP_OK = 200;
    const HTTP_CREATED = 201;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;
    const HTTP_INTERNAL_SERVER_ERROR = 500;

    public static function json($data = null, int $statusCode = self::HTTP_OK, $status = "success", $message = ""): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        $response = [
            "status" => $status,
            "message" => $message,
            "data" => $data
        ];

        if ($data === null) {
            unset($response["data"]);
        }

        echo json_encode($response);
        exit(); 
    }

    public static function success($data = null, $message = "Operación exitosa"): void
    {
        self::json($data, self::HTTP_OK, "success", $message);
    }

    public static function created($data = null, $message = "Recurso creado exitosamente"): void
    {
        self::json($data, self::HTTP_CREATED, "success", $message);
    }

    public static function error($message, int $statusCode = self::HTTP_BAD_REQUEST): void
    {
        self::json(null, $statusCode, "error", $message);
    }

    public static function notFound($message = "Recurso no encontrado"): void
    {
        self::error($message, self::HTTP_NOT_FOUND);
    }

    public static function methodNotAllowed($message = "Método no permitido"): void
    {
        self::error($message, self::HTTP_METHOD_NOT_ALLOWED);
    }

    public static function serverError($message = "Error interno del servidor"): void
    {
        self::error($message, self::HTTP_INTERNAL_SERVER_ERROR);
    }
}
