<?php

namespace App\Controllers;

use App\Models\ArtifactsModel;
use App\Models\ArtistModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    public function index()
    {
        $artifactsModel = new ArtifactsModel();
        $artistModel = new ArtistModel();

        $artifacts = $artifactsModel
            ->select('artifacts.*, artists.name AS artist_name, categories.name AS category_name, users.username AS user_name, model_files.file_path AS model_file_path')
            ->join('artists', 'artists.artist_id = artifacts.artist_id', 'left')
            ->join('categories', 'categories.category_id = artifacts.category_id', 'left')
            ->join('users', 'users.user_id = artifacts.user_id', 'left')
            ->join('model_files', 'model_files.model_id = artifacts.model_id', 'left')
            ->findAll();

        $artists = $artistModel->findAll();

        $data = [
            'title' => 'Rinconada Artifact CMS Homepage',
            'artifacts' => $artifacts,
            'artists' => $artists,
        ];

        return view('home', $data);
    }
}
