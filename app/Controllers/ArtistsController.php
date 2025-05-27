<?php

namespace App\Controllers;

use App\Models\ArtistModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ArtistsController extends BaseController
{
    protected $artistModel;

    public function __construct()
    {
        $this->artistModel = new ArtistModel();
    }

    // List all artists
    public function index()
    {
        $data = [
            'artists' => $this->artistModel->findAll(),
            'title' => 'Artists List'
        ];
        return view('artists/index', $data);
    }

    // Show single artist
    public function show($artist_id = null)
    {
        $artist = $this->artistModel->find($artist_id);
        if ($artist === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('artists/show', [
            'artist' => $artist,
            'title' => $artist['name']
        ]);
    }

    // Show create form
    public function new()
    {
        return view('artists/create', [
            'title' => 'Add New Artist'
        ]);
    }

    // Create artist
    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[150]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = [
            'name' => $this->request->getPost('name'),
            'biography' => $this->request->getPost('biography'),
            'municipality' => $this->request->getPost('municipality'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
        try {
            $this->artistModel->insert($data);
            return redirect()->to('/artists')->with('success', 'Artist created successfully');
        } catch (\Exception $e) {
            log_message('error', 'Error creating artist: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create artist');
        }
    }

    // Show edit form
    public function edit($artist_id = null)
    {
        $artist = $this->artistModel->find($artist_id);
        if ($artist === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        return view('artists/edit', [
            'artist' => $artist,
            'title' => 'Edit ' . $artist['name']
        ]);
    }

    // Update artist
    public function update($artist_id = null)
    {
        $artist = $this->artistModel->find($artist_id);
        if ($artist === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        $rules = [
            'name' => 'required|min_length[3]|max_length[150]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = [
            'name' => $this->request->getPost('name'),
            'biography' => $this->request->getPost('biography'),
            'municipality' => $this->request->getPost('municipality'),
        ];
        try {
            $this->artistModel->update($artist_id, $data);
            return redirect()->to('/artists')->with('success', 'Artist updated successfully');
        } catch (\Exception $e) {
            log_message('error', 'Error updating artist: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to update artist');
        }
    }

    // Delete artist
    public function delete($artist_id = null)
    {
        $artist = $this->artistModel->find($artist_id);
        if ($artist === null) {
            throw PageNotFoundException::forPageNotFound();
        }
        try {
            $this->artistModel->delete($artist_id);
            return redirect()->to('/artists')->with('success', 'Artist deleted successfully');
        } catch (\Exception $e) {
            log_message('error', 'Error deleting artist: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete artist');
        }
    }
} 