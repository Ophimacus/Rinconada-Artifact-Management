<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtistModel extends Model
{
    protected $table = 'artists';
    protected $primaryKey = 'artist_id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name', 'biography', 'municipality', 'created_at'
    ];
    protected $useTimestamps = false;
}