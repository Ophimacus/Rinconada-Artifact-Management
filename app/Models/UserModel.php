<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'username', 'email', 'password', 'is_admin', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required',
            'is_unique' => 'This username is already taken'
        ]
    ];

    protected $skipValidation = false;
} 