<?php

namespace App\Controllers;

use App\Models\ArtifactsModel;
use App\Models\ArtistModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\ModelFilesModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;

class ArtifactsController extends BaseController
{
    protected $artifactsModel;
    protected $artistModel;
    protected $categoryModel;
    protected $userModel;
    protected $modelFilesModel;

    public function __construct()
    {
        $this->artifactsModel = new ArtifactsModel();
        $this->artistModel = new ArtistModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->modelFilesModel = new ModelFilesModel();
    }

    // List all artifacts
    public function index()
    {
        $artifacts = $this->artifactsModel
            ->select('artifacts.*, artists.name AS artist_name, categories.name AS category_name, users.username AS user_name, model_files.file_path AS model_file_path')
            ->join('artists', 'artists.artist_id = artifacts.artist_id', 'left')
            ->join('categories', 'categories.category_id = artifacts.category_id', 'left')
            ->join('users', 'users.user_id = artifacts.user_id', 'left')
            ->join('model_files', 'model_files.model_id = artifacts.model_id', 'left')
            ->findAll();
        
        $data = [
            'artifacts' => $artifacts,
            'title' => 'Artifacts List'
        ];
        
        return view('artifacts/index', $data);
    }

    // Show single artifact
    public function show($artifact_id = null)
    {
        $artifact = $this->artifactsModel
            ->select('artifacts.*, artists.name AS artist_name, categories.name AS category_name, users.username AS user_name, model_files.file_path AS model_file_path')
            ->join('artists', 'artists.artist_id = artifacts.artist_id', 'left')
            ->join('categories', 'categories.category_id = artifacts.category_id', 'left')
            ->join('users', 'users.user_id = artifacts.user_id', 'left')
            ->join('model_files', 'model_files.model_id = artifacts.model_id', 'left')
            ->find($artifact_id);
            
        if ($artifact === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        
        return view('artifacts/show', [
            'artifact' => $artifact,
            'title' => $artifact['title']
        ]);
    }

    // Show create form
    public function new()
    {
        $data = [
            'title' => 'Add New Artifact',
            'artists' => $this->artistModel->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'users' => $this->userModel->findAll()
        ];
        
        return view('artifacts/create', $data);
    }

    // Create artifact
    public function create()
    {
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        log_message('debug', 'ArtifactsController::create() called');
        log_message('debug', 'POST: ' . print_r($this->request->getPost(), true));
        log_message('debug', 'FILES: ' . print_r($_FILES, true));
        
        // First, validate all non-file fields
        $rules = [
            'title' => 'required|min_length[3]|max_length[150]',
            'category_id' => 'required|integer',
            'artist_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
        
        // Initialize validation with custom error messages
        $validation = \Config\Services::validation();
        $validation->setRules($rules);
        
        // First validate non-file fields
        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', 'Validation failed: ' . print_r($validation->getErrors(), true));
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }
        
        // Handle file upload
        $modelFile = $this->request->getFile('model_file');
        if (!$modelFile) {
            log_message('error', 'No file found in request!');
        } else {
            log_message('debug', 'modelFile->isValid(): ' . ($modelFile->isValid() ? 'true' : 'false'));
            log_message('debug', 'modelFile->getError(): ' . $modelFile->getError());
            log_message('debug', 'modelFile->getErrorString(): ' . $modelFile->getErrorString());
        }
        // Remove all file validation for testing
        // Proceed to save any uploaded file, regardless of type or size
        
        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // First, upload the model file
            $originalExtension = $modelFile->getClientExtension();
            $randomBase = bin2hex(random_bytes(8));
            $newName = $randomBase . '.' . $originalExtension;
            $uploadPath = WRITEPATH . 'uploads/models';
            
            // Ensure upload directory exists
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Move the uploaded file
            $modelFile->move($uploadPath, $newName);
            $filePath = 'uploads/models/' . $newName;
            
            // Create model file record
            $modelData = [
                'file_name' => $modelFile->getClientName(),
                'file_path' => $filePath,
                'file_size_kb' => (int) round($modelFile->getSize() / 1024),
                'uploaded_at' => date('Y-m-d H:i:s'),
                'artifact_id' => null // Will be updated after artifact creation
            ];
            
            $modelId = $this->modelFilesModel->insert($modelData);
            
            if (!$modelId) {
                $validationErrors = $this->modelFilesModel->errors();
                log_message('error', 'ModelFilesModel insert failed. Validation errors: ' . print_r($validationErrors, true));
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to save model file record: ' . json_encode($validationErrors));
            }
            
            // Create artifact record
            $artifactData = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'origin' => $this->request->getPost('origin'),
                'municipality' => $this->request->getPost('municipality'),
                'category_id' => $this->request->getPost('category_id'),
                'artist_id' => $this->request->getPost('artist_id'),
                'user_id' => $this->request->getPost('user_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'model_id' => $modelId
            ];
            
            $artifactId = $this->artifactsModel->insert($artifactData);
            
            if (!$artifactId) {
                throw new \RuntimeException('Failed to create artifact record');
            }
            
            // Update model file with artifact ID
            $this->modelFilesModel->update($modelId, ['artifact_id' => $artifactId]);
            
            // Commit transaction
            $db->transCommit();
            
            // Clear form data from session
            $this->session->remove('_ci_old_input');
            
            return redirect()->to('/artifacts')->with('success', 'Artifact created successfully!');
            
        } catch (\Exception $e) {
            // Rollback transaction on error
            if (isset($db) && $db->transStatus() !== false) {
                $db->transRollback();
            }
            
            // Clean up uploaded file if it exists
            if (isset($filePath) && file_exists(WRITEPATH . $filePath)) {
                @unlink(WRITEPATH . $filePath);
            }
            
            log_message('error', 'Error creating artifact: ' . $e->getMessage());
            
            // Log the full error details
            $errorMessage = 'Error creating artifact: ' . $e->getMessage();
            $errorDetails = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'post_data' => $this->request->getPost(),
                'files_data' => $_FILES
            ];
            
            log_message('error', $errorMessage);
            log_message('error', 'Error details: ' . print_r($errorDetails, true));
            
            // Prepare user-friendly error message
            $userMessage = 'Failed to create artifact. ';
            
            // Add more specific error messages for common issues
            if (strpos($e->getMessage(), 'upload directory') !== false) {
                $userMessage .= 'There was a problem with the file upload directory. Please try again or contact support.';
            } elseif (strpos($e->getMessage(), 'file type') !== false) {
                $userMessage .= 'Invalid file type. Please upload a valid 3D model file.';
            } elseif (strpos($e->getMessage(), 'too large') !== false) {
                $userMessage .= 'The file is too large. Maximum size is 100MB.';
            } else {
                $userMessage .= 'Please check your input and try again. If the problem persists, contact support.';
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $userMessage);
        }
    }

    // Show edit form
    public function edit($artifact_id = null)
    {
        $artifact = $this->artifactsModel
            ->select('artifacts.*, model_files.file_path AS model_file_path')
            ->join('model_files', 'model_files.model_id = artifacts.model_id', 'left')
            ->find($artifact_id);

        if ($artifact === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        
        $data = [
            'artifact' => $artifact,
            'title' => 'Edit ' . $artifact['title'],
            'artists' => $this->artistModel->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'users' => $this->userModel->findAll()
        ];
        
        return view('artifacts/edit', $data);
    }

    // Update artifact
    public function update($artifact_id = null)
    {
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        log_message('debug', '=== UPDATE ARTIFACT STARTED ===');
        log_message('debug', 'Artifact ID: ' . $artifact_id);
        log_message('debug', 'POST Data: ' . print_r($this->request->getPost(), true));
        
        $artifact = $this->artifactsModel->find($artifact_id);
        if ($artifact === null) {
            log_message('error', 'Artifact not found with ID: ' . $artifact_id);
            throw PageNotFoundException::forPageNotFound();
        }

        $modelFile = $this->request->getFile('model_file');
        // Define validation rules
        $rules = [
            'title' => [
                'label' => 'Title',
                'rules' => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required' => 'The {field} field is required',
                    'min_length' => 'The {field} must be at least {param} characters',
                    'max_length' => 'The {field} cannot exceed {param} characters'
                ]
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty|max_length[1000]',
                'errors' => [
                    'max_length' => 'The {field} cannot exceed {param} characters'
                ]
            ],
            'origin' => [
                'label' => 'Origin',
                'rules' => 'permit_empty|max_length[150]',
                'errors' => [
                    'max_length' => 'The {field} cannot exceed {param} characters'
                ]
            ],
            'municipality' => [
                'label' => 'Municipality',
                'rules' => 'permit_empty|max_length[150]',
                'errors' => [
                    'max_length' => 'The {field} cannot exceed {param} characters'
                ]
            ],
            'category_id' => [
                'label' => 'Category',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Please select a {field}',
                    'integer' => 'Invalid {field} selected'
                ]
            ],
            'artist_id' => [
                'label' => 'Artist',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Please select an {field}',
                    'integer' => 'Invalid {field} selected'
                ]
            ],
            'user_id' => [
                'label' => 'User',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Please select a {field}',
                    'integer' => 'Invalid {field} selected'
                ]
            ]
        ];

        // Check if a file was uploaded
        $modelFile = $this->request->getFile('model_file');
        $removeFile = (bool)$this->request->getPost('remove_file');

        // Only validate model_file if it's being uploaded
        if ($modelFile && $modelFile->isValid() && !$removeFile) {
            $rules['model_file'] = [
                'label' => 'File',
                'rules' => [
                    'uploaded[model_file]',
                    'max_size[model_file,102400]' // 100MB
                ],
                'errors' => [
                    'uploaded' => 'Please select a file to upload',
                    'max_size' => 'The file is too large. Maximum size is 100MB'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . print_r($this->validator->getErrors(), true));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Get the existing model ID if it exists
            $modelId = $artifact['model_id'] ?? null;
            $filePath = null;
            $removeFile = (bool)$this->request->getPost('remove_file');
            
            // Handle file removal if requested
            if ($removeFile && $modelId) {
                log_message('debug', 'Removing existing model file');
                $oldModel = $this->modelFilesModel->find($modelId);
                if ($oldModel) {
                    // Delete the physical file
                    if (!empty($oldModel['file_path']) && file_exists(WRITEPATH . $oldModel['file_path'])) {
                        log_message('debug', 'Deleting file: ' . WRITEPATH . $oldModel['file_path']);
                        @unlink(WRITEPATH . $oldModel['file_path']);
                    }
                    // Delete the model record
                    $this->modelFilesModel->delete($modelId);
                    $modelId = null; // Reset model ID since we removed the file
                }
            }
            // Handle new file upload if provided
            elseif ($modelFile && $modelFile->isValid() && !$modelFile->hasMoved() && $modelFile->getSize() > 0) {
                log_message('debug', 'Processing file upload');

                // Delete old model file if exists
                if (!empty($modelId)) {
                    $oldModel = $this->modelFilesModel->find($modelId);
                    if ($oldModel) {
                        if (!empty($oldModel['file_path']) && file_exists(WRITEPATH . $oldModel['file_path'])) {
                            log_message('debug', 'Deleting old file: ' . WRITEPATH . $oldModel['file_path']);
                            @unlink(WRITEPATH . $oldModel['file_path']);
                        }
                    }
                } else {
                    // If no existing model, create a new one
                    $modelId = null;
                }

                $newName = $modelFile->getRandomName();
                $uploadPath = WRITEPATH . 'uploads/models';

                // Ensure upload directory exists and is writable
                if (!is_dir($uploadPath)) {
                    if (!@mkdir($uploadPath, 0777, true)) {
                        throw new \RuntimeException('Failed to create upload directory: ' . $uploadPath);
                    }
                } elseif (!is_writable($uploadPath)) {
                    throw new \RuntimeException('Upload directory is not writable: ' . $uploadPath);
                }

                log_message('debug', 'Moving uploaded file to: ' . $uploadPath . '/' . $newName);
                $modelFile->move($uploadPath, $newName);
                $filePath = 'uploads/models/' . $newName;
                
                // Verify the file was moved successfully
                if (!file_exists(WRITEPATH . $filePath)) {
                    throw new \RuntimeException('Failed to move uploaded file to destination');
                }

                $modelData = [
                    'file_name' => $modelFile->getClientName(),
                    'file_path' => $filePath,
                    'file_size_kb' => (int) round($modelFile->getSize() / 1024),
                    'file_extension' => $modelFile->getClientExtension(),
                    'mime_type' => $modelFile->getMimeType(),
                    'uploaded_at' => date('Y-m-d H:i:s'),
                    'artifact_id' => $artifact_id,
                ];

                if (!empty($modelId)) {
                    // Update existing model file
                    log_message('debug', 'Updating model file with ID: ' . $modelId);
                    $this->modelFilesModel->update($modelId, $modelData);
                } else {
                    // Create new model file
                    log_message('debug', 'Creating new model file');
                    $modelId = $this->modelFilesModel->insert($modelData);
                    if (!$modelId) {
                        $dbError = $this->modelFilesModel->errors();
                        log_message('error', 'Failed to save model file: ' . print_r($dbError, true));
                        throw new \RuntimeException('Failed to save model file information');
                    }
                }
            }

            // Prepare artifact data
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'origin' => $this->request->getPost('origin'),
                'municipality' => $this->request->getPost('municipality'),
                'category_id' => (int)$this->request->getPost('category_id'),
                'artist_id' => (int)$this->request->getPost('artist_id'),
                'user_id' => (int)$this->request->getPost('user_id'),
            ];
            
            // Update model_id if we have a new model file or if we removed the file
            if (isset($modelId) || $removeFile) {
                $data['model_id'] = $modelId; // This will be null if file was removed
            }

            log_message('debug', 'Updating artifact with data: ' . print_r($data, true));
            $result = $this->artifactsModel->update($artifact_id, $data);
            
            if (!$result) {
                throw new \RuntimeException('Failed to update artifact');
            }
            
            // Commit transaction
            $db->transCommit();
            log_message('debug', 'Artifact updated successfully');
            
            return redirect()->to('/artifacts')->with('success', 'Artifact updated successfully');
            
        } catch (\Exception $e) {
            // Rollback transaction on error if it was started
            if (isset($db) && $db->transStatus() !== false) {
                $db->transRollback();
            }
            
            // Clean up uploaded file if it exists
            if (isset($filePath) && file_exists(WRITEPATH . $filePath)) {
                @unlink(WRITEPATH . $filePath);
            }
            
            // Log detailed error information
            $errorDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'post_data' => $this->request->getPost(),
                'files_data' => $_FILES
            ];
            
            log_message('error', 'Error updating artifact: ' . print_r($errorDetails, true));
            
            // Prepare user-friendly error message
            $userMessage = 'Failed to update artifact. ';
            if (strpos($e->getMessage(), 'upload directory') !== false) {
                $userMessage .= 'There was a problem with the file upload directory. Please try again or contact support.';
            } elseif (strpos($e->getMessage(), 'file type') !== false) {
                $userMessage .= 'Invalid file type. Please upload a valid 3D model file.';
            } elseif (strpos($e->getMessage(), 'too large') !== false) {
                $userMessage .= 'The file is too large. Maximum size is 100MB.';
            } else {
                $userMessage .= 'Please check your input and try again. If the problem persists, contact support.';
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', $userMessage);
        }
    }

    // Delete artifact
    public function delete($artifact_id = null)
    {
        $artifact = $this->artifactsModel->find($artifact_id);
        if ($artifact === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Delete associated model file if exists
            if (!empty($artifact['model_id'])) {
                $model = $this->modelFilesModel->find($artifact['model_id']);
                if ($model) {
                    // Delete the physical file
                    if (!empty($model['file_path']) && file_exists(WRITEPATH . $model['file_path'])) {
                        unlink(WRITEPATH . $model['file_path']);
                    }
                    // Delete the model record
                    $this->modelFilesModel->delete($model['model_id']);
                }
            }

            // Delete the artifact
            $this->artifactsModel->delete($artifact_id);
            
            // Commit transaction
            $db->transCommit();
            
            return redirect()->to('/artifacts')->with('success', 'Artifact deleted successfully');
            
        } catch (\Exception $e) {
            // Rollback transaction on error
            $db->transRollback();
            
            log_message('error', 'Error deleting artifact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete artifact: ' . $e->getMessage());
        }
    }
}
