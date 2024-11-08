<?php

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/lib/Database.php';

use App\Lib\Database;

try {
    $db = Database::getInstance()->getConnection();
    echo "Conexión a la base de datos establecida exitosamente.";
} catch (Exception $e) {
    echo "Error en la conexión a la base de datos: " . $e->getMessage();
}