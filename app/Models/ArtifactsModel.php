<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtifactsModel extends Model
{
    protected $table = 'artifacts';
    protected $primaryKey = 'artifact_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'title', 'description', 'origin', 'municipality', 'category_id', 'artist_id', 'user_id', 'created_at', 'model_id'
    ];
    protected $useTimestamps = false;
} 