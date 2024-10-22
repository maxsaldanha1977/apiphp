<?php 

namespace App\Models;

use App\Models\Database;
use PDO;

class Endereco extends Database
{
    public static function save(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            INSERT 
            INTO 
                endereco (rua, cidade, estado, cep)
            VALUES
                (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['rua'],
            $data['cidade'],
            $data['estado'],
            $data['cep']
        ]);

        return $pdo->lastInsertId() > 0 ? true : false;
    }
   

    public static function find(int|string $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare('
            SELECT 
                id, rua, cidade, estado, cep
            FROM 
                endereco
            WHERE 
                id = ?
        ');

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function findAll()
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare('
            SELECT 
                id, rua, cidade, estado, cep
            FROM 
                endereco
        ');

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update(int|string $id, array $data)
    {
        $pdo = self::getConnection();
        
        $stmt = $pdo->prepare('
            UPDATE 
                endereco
            SET 
               rua = ?, 
               cidade = ?, 
               estado = ?, 
               cep = ?
            WHERE 
                id = ?
        ');

        $stmt->execute([$data['rua'], $data['cidade'], $data['estado'],  $data['enderoco_id'], $id]);  //Defini os campos que serão afetados para UserService.php

        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function delete(int|string $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare('
            DELETE 
            FROM 
                endereco
            WHERE 
                id = ?
        ');

        $stmt->execute([$id]);

        return $stmt->rowCount() > 0 ? true : false;
    }
}