<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelModel extends Model
{
    protected $table = 'artifacts';
    protected $primaryKey = 'artifact_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'title', 'description', 'origin', 'municipality', 'category_id', 'artist_id', 'user_id', 'created_at', 'file_path', 'model_id'
    ];
    protected $useTimestamps = false;
} 