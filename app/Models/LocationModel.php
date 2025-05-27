<?php

namespace App\Models;

use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'locations';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    
    protected $allowedFields = [
        'name', 'address', 'city', 'country', 'coordinates',
        'type', 'contact_info', 'website', 'description'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'city' => 'required',
        'country' => 'required'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Location name is required',
            'min_length' => 'Location name must be at least 3 characters long',
            'max_length' => 'Location name cannot exceed 255 characters'
        ]
    ];

    protected $skipValidation = false;

    // Get all models associated with a location
    public function getModels($locationId)
    {
        $modelModel = new ModelModel();
        return $modelModel->where('current_location', $locationId)->findAll();
    }

    // Get location statistics
    public function getStatistics($locationId)
    {
        $modelModel = new ModelModel();
        $stats = [
            'total_models' => $modelModel->where('current_location', $locationId)->countAllResults(),
            'models_by_period' => $this->getModelsByPeriod($locationId),
            'models_by_style' => $this->getModelsByStyle($locationId)
        ];
        return $stats;
    }

    private function getModelsByPeriod($locationId)
    {
        $modelModel = new ModelModel();
        return $modelModel->select('period, COUNT(*) as count')
                         ->where('current_location', $locationId)
                         ->groupBy('period')
                         ->findAll();
    }

    private function getModelsByStyle($locationId)
    {
        $modelModel = new ModelModel();
        return $modelModel->select('style, COUNT(*) as count')
                         ->where('current_location', $locationId)
                         ->groupBy('style')
                         ->findAll();
    }
} 