<?php

namespace App\Libraries;

class ModelProcessor
{
    private $allowedFormats = ['obj', 'fbx', 'gltf', 'glb', 'stl', 'ply'];
    private $maxFileSize = 104857600; // 100MB
    private $uploadPath;
    private $thumbnailPath;

    public function __construct()
    {
        $this->uploadPath = WRITEPATH . 'uploads/models/';
        $this->thumbnailPath = WRITEPATH . 'uploads/thumbnails/';
        
        // Create directories if they don't exist
        if (!is_dir($this->uploadPath)) {
            mkdir($this->uploadPath, 0777, true);
        }
        if (!is_dir($this->thumbnailPath)) {
            mkdir($this->thumbnailPath, 0777, true);
        }
    }

    public function validateFile($file)
    {
        if (!$file->isValid()) {
            throw new \RuntimeException($file->getErrorString());
        }

        if ($file->getSize() > $this->maxFileSize) {
            throw new \RuntimeException('File size exceeds limit');
        }

        $ext = strtolower($file->getClientExtension());
        if (!in_array($ext, $this->allowedFormats)) {
            throw new \RuntimeException('Invalid file format');
        }

        return true;
    }

    public function processUpload($file)
    {
        $this->validateFile($file);

        $newName = $this->generateUniqueFilename($file);
        $file->move($this->uploadPath, $newName);

        return [
            'file_path' => 'uploads/models/' . $newName,
            'file_size' => $file->getSize(),
            'file_format' => $file->getClientExtension()
        ];
    }

    public function generateThumbnail($modelPath)
    {
        // TODO: Implement thumbnail generation
        // This would typically use a 3D rendering library to create a preview image
        $thumbnailName = pathinfo($modelPath, PATHINFO_FILENAME) . '.png';
        return 'uploads/thumbnails/' . $thumbnailName;
    }

    public function optimizeModel($modelPath)
    {
        // TODO: Implement model optimization
        // This would typically use tools like Draco or other 3D optimization libraries
        return true;
    }

    public function extractMetadata($modelPath)
    {
        $metadata = [
            'format' => pathinfo($modelPath, PATHINFO_EXTENSION),
            'size' => filesize(WRITEPATH . $modelPath),
            'created' => date('Y-m-d H:i:s', filectime(WRITEPATH . $modelPath)),
            'modified' => date('Y-m-d H:i:s', filemtime(WRITEPATH . $modelPath))
        ];

        // TODO: Extract more metadata based on file format
        // This would typically use format-specific libraries to extract:
        // - Polygon count
        // - Texture information
        // - Materials
        // - etc.

        return $metadata;
    }

    private function generateUniqueFilename($file)
    {
        $extension = $file->getClientExtension();
        $basename = bin2hex(random_bytes(8));
        return sprintf('%s_%s.%s', date('Ymd_His'), $basename, $extension);
    }

    public function deleteModel($modelPath)
    {
        $fullPath = WRITEPATH . $modelPath;
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        // Delete associated thumbnail if it exists
        $thumbnailPath = WRITEPATH . 'uploads/thumbnails/' . pathinfo($modelPath, PATHINFO_FILENAME) . '.png';
        if (file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
    }

    public function generatePreviewUrl($modelPath, $token)
    {
        // Generate a secure, time-limited URL for model preview
        $baseUrl = site_url('uploads/models/' . basename($modelPath));
        return $baseUrl . '?token=' . $token;
    }
} 