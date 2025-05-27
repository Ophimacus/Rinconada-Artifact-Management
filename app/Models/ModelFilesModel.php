<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelFilesModel extends Model
{
    protected $table = 'model_files';
    protected $primaryKey = 'model_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'file_name', 'file_path', 'file_size_kb', 'uploaded_at', 'artifact_id', 'file_extension', 'mime_type'
    ];
    
    protected $beforeInsert = ['setUploadedAt'];
    
    protected function setUploadedAt(array $data) {
        if (!isset($data['data']['uploaded_at'])) {
            $data['data']['uploaded_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
    protected $useTimestamps = false;
    
    // Disable automatic timestamp updates
    protected $createdField  = 'uploaded_at';
    protected $updatedField  = null;
    
    // Validation rules
    protected $validationRules = [
        'file_name' => 'required|max_length[150]',
        'file_path' => 'required|max_length[255]',
        'file_size_kb' => 'permit_empty|integer'
    ];
}