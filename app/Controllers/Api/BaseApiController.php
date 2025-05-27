<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class BaseApiController extends ResourceController
{
    use ResponseTrait;

    protected function successResponse($data = null, string $message = 'Success', int $code = 200)
    {
        return $this->respond([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse(string $message = 'Error', int $code = 400, $errors = null)
    {
        $response = [
            'status' => false,
            'message' => $message
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return $this->respond($response, $code);
    }

    protected function validateRequest(array $rules, array $messages = [])
    {
        $validation = \Config\Services::validation();
        $validation->setRules($rules, $messages);

        if (!$validation->withRequest($this->request)->run()) {
            return $validation->getErrors();
        }

        return null;
    }

    protected function getRequestInput()
    {
        return $this->request->getJSON(true) ?? $this->request->getRawInput();
    }

    protected function getPaginationParams()
    {
        return [
            'page' => (int) ($this->request->getGet('page') ?? 1),
            'limit' => (int) ($this->request->getGet('limit') ?? 10),
            'sort' => $this->request->getGet('sort') ?? 'created_at',
            'order' => $this->request->getGet('order') ?? 'desc'
        ];
    }
} 