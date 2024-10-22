<?php

namespace App\Services;

use App\Http\JWT;
use App\Utils\Validator;
use Exception;
use PDOException;
use App\Models\Cliente;

class ClienteService
{
    public static function create(array $data)
    {
        try {
            $fields = Validator::validate([
                'nome'     => $data['nome']     ?? '',
                'email'    => $data['email']    ?? '',
                'telefone' => $data['telefone'] ?? '',
                 'endereco_id' => $data['endereco_id'] ?? ''
            ]);
           
            $cliente = Cliente::save($fields);

            if (!$cliente) return ['error' => 'Sorry, we could not create your account.'];

            return "cliente created successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            if ($e->errorInfo[0] === '23505') return ['error' => 'Desculpe, já existe um usuário com o email informado.'];
            if ($e->errorInfo[0] === '23000') return ['error' => 'Desculpe, já existe um usuário com o email informado.'];
            if ($e->errorInfo[0] === 'HY093') return ['error' => 'Parâmetro inválido.'];
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    
    public static function fetch(mixed $authorization, int|string $id)
    {
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized' => $authorization['error']];
            }

            $clienteFromJWT = JWT::verify($authorization);

            if (!$clienteFromJWT) return ['unauthorized' => "Please, login to access this resource."];

            $cliente = Cliente::find($id);

            if (!$cliente) return ['error' => 'Sorry, we could not find your account.'];

            return $cliente;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function fetchAll(mixed $authorization)
    {
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized' => $authorization['error']];
            }

            $clienteFromJWT = JWT::verify($authorization);

            if (!$clienteFromJWT) return ['unauthorized' => "Please, login to access this resource."];

            $cliente = Cliente::findAll();

            if (!$cliente) return ['error' => 'Sorry, we could not find your account.'];

            return $cliente;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public static function update(mixed $authorization, array $data, int|string $id)
    {
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized' => $authorization['error']];
            }

            $clienteFromJWT = JWT::verify($authorization);

            if (!$clienteFromJWT) return ['unauthorized' => "Please, login to access this resource."];
            //Defini os campos que serão afetados vindo da cliente.php
            $fields = Validator::validate([
                'nome' => $data['nome'] ?? '',
                'email'    => $data['email']    ?? '',
                'telefone' => $data['telefone'] ?? '',
                'endereco_id' => $data['endereco_id'] ?? ''
            ]);

            $cliente = Cliente::update($id, $fields);

            if (!$cliente) return ['error' => 'Sorry, we could not update your account.'];

            return "cliente updated successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function delete(mixed $authorization, int|string $id)
    {
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized' => $authorization['error']];
            }

            $clienteFromJWT = JWT::verify($authorization);

            if (!$clienteFromJWT) return ['unauthorized' => "Please, login to access this resource."];

            $cliente = Cliente::delete($id);

            if (!$cliente) return ['error' => 'Sorry, we could not delete your account.'];

            return "cliente deleted successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
