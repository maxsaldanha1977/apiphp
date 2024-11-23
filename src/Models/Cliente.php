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
                cliente.id, nome, email, telefone,
                 endereco.rua as logradouro,
            endereco.numero,
            endereco.cep,
            endereco.cidade,
            endereco.estado
            FROM 
                cliente
                   JOIN endereco ON cliente.endereco_id = endereco.id
            WHERE 
                cliente.id = ?
        ');

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function findAll()
    {
        $pdo = self::getConnection();
/* cliente.id as cliente_id, nome, email, telefone, endereco.id AS endereco_id, */
        $stmt = $pdo->prepare('
            SELECT 
                cliente.id, nome, email, telefone,
            endereco.rua as logradouro,
            endereco.numero,
            endereco.cep,
            endereco.cidade,
            endereco.estado
            FROM 
                cliente
               inner JOIN endereco ON cliente.endereco_id = endereco.id
        ');

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
/*
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $clientes = [];
    
        foreach ($resultados as $linha) {
            $clienteId = $linha['cliente_id'];
    
            // Se o cliente ainda não foi adicionado no array, inicializa
            if (!isset($clientes[$clienteId])) {
                $clientes[$clienteId] = [
                    'id' => $linha['cliente_id'],
                    'nome' => $linha['nome'],
                    'email' => $linha['email'],
                    'telefone' => $linha['telefone'],
                    'enderecos' => [] // Inicializa o array de endereços
                ];
            }
    
            // Adiciona o endereço ao array de endereços do cliente
            $clientes[$clienteId]['enderecos'][] = [
                'id' => $linha['endereco_id'],
                'rua' => $linha['rua'],
                'cep' => $linha['cep'],
                'cidade' => $linha['cidade'],
                'estado' => $linha['estado']
            ];
        }
    
        // Reindexa para garantir que a estrutura seja um array simples e não associativo por IDs
        return array_values($clientes);
        */
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

        $stmt->execute([$data['nome'], $data['email'], $data['telefone'],  $data['endereco_id'], $id]);  //Defini os campos que serão afetados para ClienteService.php

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