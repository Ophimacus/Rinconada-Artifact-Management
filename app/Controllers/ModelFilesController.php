<?php
namespace App\Controllers;

use App\Models\ModelFilesModel;
use App\Models\ModelModel;
use CodeIgniter\Controller;

class ModelFilesController extends Controller
{
    public function index()
    {
        $model = new ModelFilesModel();
        $modelFiles = $model->findAll();
        $data['model_files'] = $modelFiles;
        $data['title'] = 'Model Files';
        return view('model_files/index', $data);
    }

    public function show($id)
    {
        $model = new ModelFilesModel();
        $file = $model->find($id);
        $data['model_file'] = $file;
        $data['title'] = 'Model File Details';
        if (!$data['model_file']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Model file not found');
        }
        return view('model_files/show', $data);
    }

    public function create()
    {
        $data['title'] = 'Add New Model File';
        return view('model_files/create', $data);
    }

    public function store()
    {
        $model = new ModelFilesModel();
        $data = $this->request->getPost();
        $model->insert($data);
        return redirect()->to('/model_files');
    }

    public function edit($id)
    {
        $model = new ModelFilesModel();
        $data['model_file'] = $model->find($id);
        $data['title'] = 'Edit Model File';
        if (!$data['model_file']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Model file not found');
        }
        return view('model_files/edit', $data);
    }

    public function update($id)
    {
        $model = new ModelFilesModel();
        $data = $this->request->getPost();
        $model->update($id, $data);
        return redirect()->to('/model_files');
    }

    public function delete($id)
    {
        $model = new ModelFilesModel();
        $model->delete($id);
        return redirect()->to('/model_files');
    }
} 