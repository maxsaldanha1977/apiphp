<?php

namespace App\Services;

use App\Http\JWT;
use App\Utils\Validator;
use Exception;
use PDOException;
use App\Models\Endereco;

class EnderecoService
{
    public static function create(array $data)
    {
        try {
            $fields = Validator::validate([
                'rua'     => $data['rua']     ?? '',
                'cidade'    => $data['cidade']    ?? '',
                'estado'    => $data['estado']    ?? '',
                'cep' => $data['cep'] ?? ''
            ]);
           
            $endereco = Endereco::save($fields);

            if (!$endereco) return ['error' => 'Sorry, we could not create your account.'];

            return "endereco created successfully!";
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

    
    public static function fetch(mixed $authorization)
    {
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized' => $authorization['error']];
            }

            $enderecoFromJWT = JWT::verify($authorization);

            if (!$enderecoFromJWT) return ['unauthorized' => "Please, login to access this resource."];

            $endereco = Endereco::find($enderecoFromJWT['id']);

            if (!$endereco) return ['error' => 'Sorry, we could not find your account.'];

            return $endereco;
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

            $enderecoFromJWT = JWT::verify($authorization);

            if (!$enderecoFromJWT) return ['unauthorized' => "Please, login to access this resource."];

            $endereco = Endereco::findAll();

            if (!$endereco) return ['error' => 'Sorry, we could not find your account.'];

            return $endereco;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
    public static function update(mixed $authorization, array $data)
    {
        try {
            if (isset($authorization['error'])) {
                return ['unauthorized' => $authorization['error']];
            }

            $enderecoFromJWT = JWT::verify($authorization);

            if (!$enderecoFromJWT) return ['unauthorized' => "Please, login to access this resource."];
            //Defini os campos que serão afetados vindo da endereco.php
            $fields = Validator::validate([
                'name' => $data['name'] ?? '',
                'email'    => $data['email']    ?? '',
                'password' => $data['password'] ?? '',
            ]);

            $endereco = Endereco::update($enderecoFromJWT['id'], $fields);

            if (!$endereco) return ['error' => 'Sorry, we could not update your account.'];

            return "endereco updated successfully!";
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

            $enderecoFromJWT = JWT::verify($authorization);

            if (!$enderecoFromJWT) return ['unauthorized' => "Please, login to access this resource."];

            $endereco = Endereco::delete($id);

            if (!$endereco) return ['error' => 'Sorry, we could not delete your account.'];

            return "endereco deleted successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
            return ['error' => $e->getMessage()];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
