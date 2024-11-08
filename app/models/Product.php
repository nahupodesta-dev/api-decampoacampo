<?php

namespace App\Models;

use PDO;
use App\Lib\Database;

class Product
{
    public static function all()
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->query("SELECT * FROM productos");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("SELECT * FROM productos WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("INSERT INTO productos (nombre, descripcion, precio) VALUES (:nombre, :descripcion, :precio)");

        $query->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $query->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $query->bindParam(':precio', $data['precio'], PDO::PARAM_STR);

        $query->execute();
        return $db->lastInsertId();
    }

    public static function update($id, $data)
    {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio WHERE id = :id");

        $query->bindParam(':nombre', $data['nombre'], PDO::PARAM_STR);
        $query->bindParam(':descripcion', $data['descripcion'], PDO::PARAM_STR);
        $query->bindParam(':precio', $data['precio'], PDO::PARAM_STR);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        return $query->execute();
    }

    public static function delete($id): bool
    {
        $db = Database::getInstance()->getConnection();
        
        $query = $db->prepare("DELETE FROM productos WHERE id = :id");
        $query->bindParam(':id', $id, PDO::PARAM_INT);
    
        $query->execute();
        
        return $query->rowCount() > 0;
    }
}