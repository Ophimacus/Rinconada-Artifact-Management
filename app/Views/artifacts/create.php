<?php
/** @var string $title */
/** @var array $artists */
/** @var array $categories */
/** @var array $users */
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    
    <?php if (session()->has('errors')): ?>
        <div class="alert alert-danger">
            <h5>Please fix the following errors:</h5>
            <ul class="mb-0">
                <?php foreach (session('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if (session()->has('error')): ?>
        <div class="alert alert-danger">
            <?= esc(session('error')) ?>
        </div>
    <?php endif; ?>
    
    <?php if (session()->has('success')): ?>
        <div class="alert alert-success">
            <?= esc(session('success')) ?>
        </div>
    <?php endif; ?>
    
    <form method="post" action="<?= site_url('artifacts/create') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required value="<?= old('title') ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"><?= old('description') ?></textarea>
        </div>
        <div class="mb-3">
            <label for="origin" class="form-label">Origin</label>
            <input type="text" class="form-control" id="origin" name="origin" value="<?= old('origin') ?>">
        </div>
        <div class="mb-3">
            <label for="municipality" class="form-label">Municipality</label>
            <input type="text" class="form-control" id="municipality" name="municipality" value="<?= old('municipality') ?>">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-select" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= old('category_id') == $cat['category_id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="artist_id" class="form-label">Artist</label>
            <select class="form-select" id="artist_id" name="artist_id" required>
                <option value="">Select Artist</option>
                <?php foreach ($artists as $artist): ?>
                    <option value="<?= $artist['artist_id'] ?>" <?= old('artist_id') == $artist['artist_id'] ? 'selected' : '' ?>><?= esc($artist['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Uploaded By</label>
            <select class="form-select" id="user_id" name="user_id" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['user_id'] ?>" <?= old('user_id') == $user['user_id'] ? 'selected' : '' ?>><?= esc($user['username']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="model_file" class="form-label">File <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="model_file" name="model_file" required>
            <div class="form-text">Upload any file. Max size: 100MB</div>
            <?php if (session()->has('errors.model_file')): ?>
                <div class="invalid-feedback d-block">
                    <?= esc(session('errors')['model_file']) ?>
                </div>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-success">Create Artifact</button>
        <a href="<?= site_url('artifacts') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?>