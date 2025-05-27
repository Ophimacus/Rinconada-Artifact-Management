<?php

namespace App\Controllers\Api;

use App\Models\ModelModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class ModelApiController extends BaseApiController
{
    protected $modelModel;

    public function __construct()
    {
        $this->modelModel = new ModelModel();
    }

    // GET /api/models
    public function index()
    {
        $filters = $this->request->getGet();
        $pagination = $this->getPaginationParams();
        try {
            $artifacts = $this->modelModel->findAll();
            return $this->successResponse($artifacts);
        } catch (\Exception $e) {
            return $this->errorResponse('Error fetching artifacts: ' . $e->getMessage());
        }
    }

    // GET /api/models/{id}
    public function show($id = null)
    {
        try {
            $artifact = $this->modelModel->find($id);
            if (!$artifact) {
                return $this->errorResponse('Artifact not found', 404);
            }
            return $this->successResponse($artifact);
        } catch (\Exception $e) {
            return $this->errorResponse('Error fetching artifact: ' . $e->getMessage());
        }
    }

    // POST /api/models
    public function create()
    {
        $input = $this->getRequestInput();
        $rules = [
            'title' => 'required|min_length[3]',
            'artist_id' => 'required|integer',
        ];
        if ($errors = $this->validateRequest($rules)) {
            return $this->errorResponse('Validation error', 400, $errors);
        }
        try {
            $artifactId = $this->modelModel->insert($input);
            $artifact = $this->modelModel->find($artifactId);
            return $this->successResponse($artifact, 'Artifact created successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('Error creating artifact: ' . $e->getMessage());
        }
    }

    // PUT /api/models/{id}
    public function update($id = null)
    {
        try {
            if (!$this->modelModel->find($id)) {
                return $this->errorResponse('Artifact not found', 404);
            }
            $input = $this->getRequestInput();
            $this->modelModel->update($id, $input);
            $artifact = $this->modelModel->find($id);
            return $this->successResponse($artifact, 'Artifact updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error updating artifact: ' . $e->getMessage());
        }
    }

    // DELETE /api/models/{id}
    public function delete($id = null)
    {
        try {
            if (!$this->modelModel->find($id)) {
                return $this->errorResponse('Artifact not found', 404);
            }
            $this->modelModel->delete($id);
            return $this->successResponse(null, 'Artifact deleted successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Error deleting artifact: ' . $e->getMessage());
        }
    }

    // POST /api/models/upload
    public function upload()
    {
        // This should be refactored to use model_files if you want to handle file uploads
        return $this->errorResponse('Not implemented for artifacts. Use model_files endpoint.', 501);
    }

    // GET /api/models/{id}/preview
    public function preview($id = null)
    {
        // Not implemented for artifacts
        return $this->errorResponse('Preview not implemented for artifacts.', 501);
    }

    private function generatePreviewToken($artifactId)
    {
        // Generate a secure token for artifact preview
        return hash('sha256', $artifactId . time() . env('app.key'));
    }
} 