<?php
namespace App\Controllers;

use App\Models\ModelModel;
use App\Models\ArtistModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\ModelFilesModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;

class ModelsController extends BaseController
{
    protected $modelModel;
    protected $artistModel;
    protected $categoryModel;
    protected $userModel;
    protected $modelFilesModel;

    public function __construct()
    {
        $this->modelModel = new ModelModel();
        $this->artistModel = new ArtistModel();
        $this->categoryModel = new CategoryModel();
        $this->userModel = new UserModel();
        $this->modelFilesModel = new ModelFilesModel();
    }

    // List all models
    public function index()
    {
        $artifacts = $this->modelModel
            ->select('artifacts.*, artists.name AS artist_name, categories.name AS category_name, users.username AS user_name, model_files.file_path AS model_file_path')
            ->join('artists', 'artists.artist_id = artifacts.artist_id', 'left')
            ->join('categories', 'categories.category_id = artifacts.category_id', 'left')
            ->join('users', 'users.user_id = artifacts.user_id', 'left')
            ->join('model_files', 'model_files.model_id = artifacts.model_id', 'left')
            ->findAll();
        $data = [
            'artifacts' => $artifacts,
            'title' => '3D Artifacts List'
        ];
        return view('models/index', $data);
    }

    // Show single model
    public function show($artifact_id = null)
    {
        $artifact = $this->modelModel
            ->select('artifacts.*, artists.name AS artist_name, categories.name AS category_name, users.username AS user_name, model_files.file_path AS model_file_path')
            ->join('artists', 'artists.artist_id = artifacts.artist_id', 'left')
            ->join('categories', 'categories.category_id = artifacts.category_id', 'left')
            ->join('users', 'users.user_id = artifacts.user_id', 'left')
            ->join('model_files', 'model_files.model_id = artifacts.model_id', 'left')
            ->find($artifact_id);
        if ($artifact === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('models/show', [
            'artifact' => $artifact,
            'title' => $artifact['title']
        ]);
    }

    // Show create form
    public function new()
    {
        $data = [
            'title' => 'Add New 3D Artifact',
            'artists' => $this->artistModel->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'users' => $this->userModel->findAll()
        ];
        return view('models/create', $data);
    }

    // Create model
    public function create()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        log_message('debug', 'ModelsController::create() called');
        log_message('debug', 'POST: ' . print_r($this->request->getPost(), true));
        log_message('debug', 'FILES: ' . print_r($_FILES, true));
        $rules = [
            'title' => 'required|min_length[3]|max_length[150]',
            'category_id' => 'required|integer',
            'artist_id' => 'required|integer',
            'user_id' => 'required|integer',
        ];
        if (!$this->validate($rules)) {
            log_message('error', 'Validation failed: ' . print_r($this->validator->getErrors(), true));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            $artifactData = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'origin' => $this->request->getPost('origin'),
                'municipality' => $this->request->getPost('municipality'),
                'category_id' => $this->request->getPost('category_id'),
                'artist_id' => $this->request->getPost('artist_id'),
                'user_id' => $this->request->getPost('user_id'),
                'created_at' => date('Y-m-d H:i:s'),
                'model_id' => null
            ];
            $artifactId = $this->modelModel->insert($artifactData);
            if (!$artifactId) {
                throw new \RuntimeException('Failed to create artifact record');
            }
            $modelId = null;
            $filePath = null;
            $modelFile = $this->request->getFile('model_file');
            if ($modelFile && $modelFile->isValid() && !$modelFile->hasMoved() && $modelFile->getSize() > 0) {
                $newName = $modelFile->getRandomName();
                $uploadPath = WRITEPATH . 'uploads/models';
                if (!is_dir($uploadPath)) {
                    if (!@mkdir($uploadPath, 0777, true)) {
                        throw new \RuntimeException('Failed to create upload directory: ' . $uploadPath);
                    }
                } elseif (!is_writable($uploadPath)) {
                    throw new \RuntimeException('Upload directory is not writable: ' . $uploadPath);
                }
                $modelFile->move($uploadPath, $newName);
                $filePath = 'uploads/models/' . $newName;
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
                    'artifact_id' => $artifactId,
                ];
                $modelId = $this->modelFilesModel->insert($modelData);
                if (!$modelId) {
                    $dbError = $this->modelFilesModel->errors();
                    log_message('error', 'Failed to save model file: ' . print_r($dbError, true));
                    throw new \RuntimeException('Failed to save model file information');
                }
                $this->modelModel->update($artifactId, ['model_id' => $modelId]);
            }
            $db->transCommit();
            log_message('debug', 'Artifact created successfully');
            return redirect()->to('/models')->with('success', '3D Artifact created successfully!');
        } catch (\Exception $e) {
            $db->transRollback();
            if (isset($filePath) && file_exists(WRITEPATH . $filePath)) {
                @unlink(WRITEPATH . $filePath);
            }
            log_message('error', 'Error creating 3D artifact: ' . $e->getMessage());
            $userMessage = 'Failed to create 3D artifact. ';
            if (strpos($e->getMessage(), 'upload directory') !== false) {
                $userMessage .= 'There was a problem with the file upload directory. Please try again or contact support.';
            } elseif (strpos($e->getMessage(), 'file type') !== false) {
                $userMessage .= 'Invalid file type. Please upload a valid 3D model file.';
            } elseif (strpos($e->getMessage(), 'too large') !== false) {
                $userMessage .= 'The file is too large. Maximum size is 100MB.';
            } else {
                $userMessage .= 'Please check your input and try again. If the problem persists, contact support.';
            }
            return redirect()->back()->withInput()->with('error', $userMessage);
        }
    }

    // Show edit form
    public function edit($artifact_id = null)
    {
        $artifact = $this->modelModel
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
        return view('models/edit', $data);
    }

    // Update model
    public function update($artifact_id = null)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        log_message('debug', '=== UPDATE 3D ARTIFACT STARTED ===');
        log_message('debug', 'Artifact ID: ' . $artifact_id);
        log_message('debug', 'POST Data: ' . print_r($this->request->getPost(), true));
        $artifact = $this->modelModel->find($artifact_id);
        if ($artifact === null) {
            log_message('error', 'Artifact not found with ID: ' . $artifact_id);
            throw PageNotFoundException::forPageNotFound();
        }
        $modelFile = $this->request->getFile('model_file');
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
        $modelFile = $this->request->getFile('model_file');
        $removeFile = (bool)$this->request->getPost('remove_file');
        if ($modelFile && $modelFile->isValid() && !$removeFile) {
            $rules['model_file'] = [
                'label' => 'File',
                'rules' => [
                    'uploaded[model_file]',
                    'max_size[model_file,102400]'
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
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            $modelId = $artifact['model_id'] ?? null;
            $filePath = null;
            $removeFile = (bool)$this->request->getPost('remove_file');
            if ($removeFile && $modelId) {
                $oldModel = $this->modelFilesModel->find($modelId);
                if ($oldModel) {
                    if (!empty($oldModel['file_path']) && file_exists(WRITEPATH . $oldModel['file_path'])) {
                        @unlink(WRITEPATH . $oldModel['file_path']);
                    }
                    $this->modelFilesModel->delete($modelId);
                    $modelId = null;
                }
            } elseif ($modelFile && $modelFile->isValid() && !$modelFile->hasMoved() && $modelFile->getSize() > 0) {
                if (!empty($modelId)) {
                    $oldModel = $this->modelFilesModel->find($modelId);
                    if ($oldModel) {
                        if (!empty($oldModel['file_path']) && file_exists(WRITEPATH . $oldModel['file_path'])) {
                            @unlink(WRITEPATH . $oldModel['file_path']);
                        }
                    }
                } else {
                    $modelId = null;
                }
                $newName = $modelFile->getRandomName();
                $uploadPath = WRITEPATH . 'uploads/models';
                if (!is_dir($uploadPath)) {
                    if (!@mkdir($uploadPath, 0777, true)) {
                        throw new \RuntimeException('Failed to create upload directory: ' . $uploadPath);
                    }
                } elseif (!is_writable($uploadPath)) {
                    throw new \RuntimeException('Upload directory is not writable: ' . $uploadPath);
                }
                $modelFile->move($uploadPath, $newName);
                $filePath = 'uploads/models/' . $newName;
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
                    $this->modelFilesModel->update($modelId, $modelData);
                } else {
                    $modelId = $this->modelFilesModel->insert($modelData);
                    if (!$modelId) {
                        $dbError = $this->modelFilesModel->errors();
                        log_message('error', 'Failed to save model file: ' . print_r($dbError, true));
                        throw new \RuntimeException('Failed to save model file information');
                    }
                }
            }
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'origin' => $this->request->getPost('origin'),
                'municipality' => $this->request->getPost('municipality'),
                'category_id' => (int)$this->request->getPost('category_id'),
                'artist_id' => (int)$this->request->getPost('artist_id'),
                'user_id' => (int)$this->request->getPost('user_id'),
            ];
            if (isset($modelId) || $removeFile) {
                $data['model_id'] = $modelId;
            }
            $result = $this->modelModel->update($artifact_id, $data);
            if (!$result) {
                throw new \RuntimeException('Failed to update 3D artifact');
            }
            $db->transCommit();
            log_message('debug', '3D Artifact updated successfully');
            return redirect()->to('/models')->with('success', '3D Artifact updated successfully');
        } catch (\Exception $e) {
            if (isset($db) && $db->transStatus() !== false) {
                $db->transRollback();
            }
            if (isset($filePath) && file_exists(WRITEPATH . $filePath)) {
                @unlink(WRITEPATH . $filePath);
            }
            $errorDetails = [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'post_data' => $this->request->getPost(),
                'files_data' => $_FILES
            ];
            log_message('error', 'Error updating 3D artifact: ' . print_r($errorDetails, true));
            $userMessage = 'Failed to update 3D artifact. ';
            if (strpos($e->getMessage(), 'upload directory') !== false) {
                $userMessage .= 'There was a problem with the file upload directory. Please try again or contact support.';
            } elseif (strpos($e->getMessage(), 'file type') !== false) {
                $userMessage .= 'Invalid file type. Please upload a valid 3D model file.';
            } elseif (strpos($e->getMessage(), 'too large') !== false) {
                $userMessage .= 'The file is too large. Maximum size is 100MB.';
            } else {
                $userMessage .= 'Please check your input and try again. If the problem persists, contact support.';
            }
            return redirect()->back()->withInput()->with('error', $userMessage);
        }
    }

    // Delete model
    public function delete($artifact_id = null)
    {
        $artifact = $this->modelModel->find($artifact_id);
        if ($artifact === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $db = \Config\Database::connect();
        $db->transStart();
        try {
            if (!empty($artifact['model_id'])) {
                $model = $this->modelFilesModel->find($artifact['model_id']);
                if ($model && !empty($model['file_path']) && file_exists(WRITEPATH . $model['file_path'])) {
                    unlink(WRITEPATH . $model['file_path']);
                }
                $this->modelFilesModel->delete($artifact['model_id']);
            }
            $this->modelModel->delete($artifact_id);
            $db->transCommit();
            return redirect()->to('/models')->with('success', '3D Artifact deleted successfully');
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error deleting 3D artifact: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete 3D artifact');
        }
    }


    public function store()
    {
        $model = new ModelModel();
        $fileModel = new \App\Models\ModelFilesModel();
        
        // Get form data
        $data = $this->request->getPost();
        
        // Remove any fields that shouldn't be mass assigned
        unset($data['artist_name']);
        unset($data['created_at']); // Let the database handle the timestamp
        
        // Basic validation
        $validation = service('validation');
        $validation->setRules([
            'title' => 'required|min_length[3]|max_length[150]',
            'category_id' => 'required|numeric',
            'artist_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'file_upload' => 'uploaded[file_upload]|max_size[file_upload,10240]',
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        
        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Handle file upload
            $file = $this->request->getFile('file_upload');
            $fileSaved = false;
            $modelId = null;
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Create uploads directory if it doesn't exist
                $uploadPath = WRITEPATH . '../public/uploads/models';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Generate unique filename and move to uploads directory
                $newName = $file->getRandomName();
                $filePath = 'uploads/models/' . $newName;
                $file->move($uploadPath, $newName);
                
                // Insert file record first to get the model_id
                $fileData = [
                    'file_name' => $file->getClientName(),
                    'file_path' => $filePath,
                    'file_size_kb' => round($file->getSize() / 1024),
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];
                
                $modelId = $fileModel->insert($fileData);
                $fileSaved = true;
            }
            
            if ($fileSaved && $modelId) {
                $data['model_id'] = $modelId;
            }
            
            // Set created_at to current time if not provided
            if (empty($data['created_at'])) {
                $data['created_at'] = date('Y-m-d H:i:s');
            }
            
            // Save the artifact
            $saved = $model->insert($data);
            
            if (!$saved) {
                throw new \RuntimeException('Failed to save artifact');
            }
            
            // Update the model file with the artifact_id if needed
            if ($modelId) {
                $fileModel->update($modelId, ['artifact_id' => $saved]);
            }
            
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                throw new \RuntimeException('Transaction failed');
            }
            
            return redirect()->to('/models')->with('success', 'Artifact saved successfully.');
            
        } catch (\Exception $e) {
            $db->transRollback();
            
            // Clean up any uploaded file if the transaction failed
            if (isset($filePath) && file_exists(WRITEPATH . '../public/' . $filePath)) {
                @unlink(WRITEPATH . '../public/' . $filePath);
            }
            
            log_message('error', 'Error saving artifact: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while saving the artifact. Please try again.')
                ->withInput();
        }
    }
}