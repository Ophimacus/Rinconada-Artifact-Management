<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;

class ArtifactsController extends BaseController
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function uploadFile($request)
    {
        // Log the start of the file upload
        $this->logger->info('File upload initiated.');

        // ... existing code ...

        // Log successful file upload
        $this->logger->info('File uploaded successfully: ' . $filePath);

        // ... existing code ...
        
        // Log the update of the artifacts
        $this->logger->info('Artifacts updated with model_id: ' . $modelFileId);

        // ... existing code ...
    }
} 