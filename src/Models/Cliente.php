<?php 

namespace App\Models;

use App\Models\Database;
use PDO;

class Cliente extends Database
{
    public static function save(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            INSERT 
            INTO 
                cliente (nome, email, telefone, endereco_id)
            VALUES
                (?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['telefone'],
            $data['endereco_id']
        ]);

        return $pdo->lastInsertId() > 0 ? true : false;
    }
   

    public static function find(int|string $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare('
            SELECT 
                id, nome, email, telefone, endereco_id
            FROM 
                cliente
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
                id, nome, email, telefone, endereco_id
            FROM 
                cliente
        ');

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update(int|string $id, array $data)
    {
        $pdo = self::getConnection();
        
        $stmt = $pdo->prepare('
            UPDATE 
                cliente
            SET 
               nome = ?, 
               email = ?, 
               telefone = ?, 
               endereco_id = ?
            WHERE 
                id = ?
        ');

        $stmt->execute([$data['nome'], $data['email'], $data['telefone'],  $data['enderoco_id'], $id]);  //Defini os campos que serão afetados para UserService.php

        return $stmt->rowCount() > 0 ? true : false;
    }

    public static function delete(int|string $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare('
            DELETE 
            FROM 
                cliente
            WHERE 
                id = ?
        ');

        $stmt->execute([$id]);

        return $stmt->rowCount() > 0 ? true : false;
    }
}