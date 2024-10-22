<?php 

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\ClienteService;

class ClienteController
{
    public function store(Request $request, Response $response)
    {
        $body = $request::body();

        $clienteService = ClienteService::create($body);

        if (isset($clienteService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $clienteService
        ], 201);
    }

  
    public function fetch(Request $request, Response $response)
    {
        $authorization = $request::authorization();

        $clienteService = ClienteService::fetch($authorization);

        if (isset($clienteService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['unauthorized']
            ], 401);
        }

        if (isset($clienteService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $clienteService
        ], 200);
        return;
    }

    public function fetchAll(Request $request, Response $response)
    {
        $authorization = $request::authorization();

        $clienteService = ClienteService::fetchAll($authorization);

        if (isset($clienteService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['unauthorized']
            ], 401);
        }

        if (isset($clienteService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $clienteService
        ], 200);
        return;
    }

    public function update(Request $request, Response $response)
    {
        $authorization = $request::authorization();

        $body = $request::body();

        $clienteService = ClienteService::update($authorization, $body);

        if (isset($clienteService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['unauthorized']
            ], 401);
        }

        if (isset($clienteService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $clienteService
        ], 200);
        return;
    }

    public function remove(Request $request, Response $response, array $id)
    {
        $authorization = $request::authorization();

        $clienteService = ClienteService::delete($authorization, $id[0]);

        if (isset($clienteService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['unauthorized']
            ], 401);
        }

        if (isset($clienteService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $clienteService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $clienteService
        ], 200);
        return;
    }
}