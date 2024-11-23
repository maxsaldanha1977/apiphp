<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\EnderecoService;

class EnderecoController
{
    public function store(Request $request, Response $response)
    {
        $body = $request::body();

        $enderecoService = EnderecoService::create($body);

        if (isset($enderecoService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $enderecoService
        ], 201);
    }

    public function fetch(Request $request, Response $response, array $id)
    {
        $authorization = $request::authorization();

        $enderecoService = EnderecoService::fetch($authorization, $id[0]);

        if (isset($enderecoService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['unauthorized']
            ], 401);
        }

        if (isset($enderecoService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $enderecoService
        ], 200);
        return;
    }

    public function fetchAll(Request $request, Response $response)
    {
        $authorization = $request::authorization();

        $enderecoService = EnderecoService::fetchAll($authorization);

        if (isset($enderecoService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['unauthorized']
            ], 401);
        }

        if (isset($enderecoService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'data'    => $enderecoService
        ], 200);
        return;
    }

    public function update(Request $request, Response $response, array $id)
    {
        $authorization = $request::authorization();

        $body = $request::body();

        $enderecoService = EnderecoService::update($authorization, $body, $id[0]);

        if (isset($enderecoService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['unauthorized']
            ], 401);
        }

        if (isset($enderecoService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $enderecoService
        ], 200);
        return;
    }

    public function remove(Request $request, Response $response, array $id)
    {
        $authorization = $request::authorization();

        $enderecoService = EnderecoService::delete($authorization, $id[0]);

        if (isset($enderecoService['unauthorized'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['unauthorized']
            ], 401);
        }

        if (isset($enderecoService['error'])) {
            return $response::json([
                'error'   => true,
                'success' => false,
                'message' => $enderecoService['error']
            ], 400);
        }

        $response::json([
            'error'   => false,
            'success' => true,
            'message' => $enderecoService
        ], 200);
        return;
    }
}
