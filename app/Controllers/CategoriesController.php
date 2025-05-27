<?php
namespace App\Controllers;

use App\Models\CategoryModel;
use CodeIgniter\Controller;

class CategoriesController extends Controller
{
    public function index()
    {
        $model = new CategoryModel();
        $categories = $model->findAll();
        $data['categories'] = $categories;
        $data['title'] = 'Categories';
        return view('categories/index', $data);
    }

    public function show($id)
    {
        $model = new CategoryModel();
        $category = $model->find($id);
        $data['category'] = $category;
        $data['title'] = 'Category Details';
        if (!$data['category']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found');
        }
        return view('categories/show', $data);
    }

    public function create()
    {
        $data['title'] = 'Add New Category';
        return view('categories/create', $data);
    }

    public function store()
    {
        $model = new CategoryModel();
        $data = $this->request->getPost();
        $model->insert($data);
        return redirect()->to('/categories');
    }

    public function edit($id)
    {
        $model = new CategoryModel();
        $data['category'] = $model->find($id);
        $data['title'] = 'Edit Category';
        if (!$data['category']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found');
        }
        return view('categories/edit', $data);
    }

    public function update($id)
    {
        $model = new CategoryModel();
        $data = $this->request->getPost();
        $model->update($id, $data);
        return redirect()->to('/categories');
    }

    public function delete($id)
    {
        $model = new CategoryModel();
        $model->delete($id);
        return redirect()->to('/categories');
    }
} 