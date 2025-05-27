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
    
    <form action="<?= site_url('models/store') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>" 
                                   id="title" name="title" value="<?= old('title') ?>" required>
                            <?php if (session('errors.title')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors')['title']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-control <?= session('errors.category_id') ? 'is-invalid' : '' ?>" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= esc($category['category_id']) ?>" 
                                        <?= old('category_id') == $category['category_id'] ? 'selected' : '' ?>>
                                        <?= esc($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.category_id')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors')['category_id']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="artist_id" class="form-label">Artist <span class="text-danger">*</span></label>
                            <select class="form-control <?= session('errors.artist_id') ? 'is-invalid' : '' ?>" 
                                    id="artist_id" name="artist_id" required>
                                <option value="">Select Artist</option>
                                <?php foreach ($artists as $artist): ?>
                                    <option value="<?= esc($artist['artist_id']) ?>"
                                        <?= old('artist_id') == $artist['artist_id'] ? 'selected' : '' ?>>
                                        <?= esc($artist['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.artist_id')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors')['artist_id']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User <span class="text-danger">*</span></label>
                            <select class="form-control <?= session('errors.user_id') ? 'is-invalid' : '' ?>" 
                                    id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                <?php foreach ($users as $user): ?>
                                    <?php if (isset($user['user_id'])): ?>
                                        <option value="<?= esc($user['user_id']) ?>"
                                            <?= old('user_id') == $user['user_id'] ? 'selected' : '' ?>>
                                            <?= esc($user['username']) ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.user_id')): ?>
                                <div class="invalid-feedback">
                                    <?= esc(session('errors')['user_id']) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="origin" class="form-label">Origin</label>
                            <input type="text" class="form-control" id="origin" name="origin" 
                                   value="<?= old('origin') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="municipality" class="form-label">Municipality</label>
                            <input type="text" class="form-control" id="municipality" name="municipality"
                                   value="<?= old('municipality') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" 
                                     rows="5"><?= old('description') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">3D Model File</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="file_upload" class="form-label">Upload 3D Model File <span class="text-danger">*</span></label>
                    <input type="file" class="form-control <?= session('errors.file_upload') ? 'is-invalid' : '' ?>" 
                           id="file_upload" name="file_upload" required>
                    <div class="form-text">
                        Supported formats: .glb, .gltf, .obj, .fbx (Max file size: 10MB)
                    </div>
                    <?php if (session('errors.file_upload')): ?>
                        <div class="invalid-feedback">
                            <?= esc(session('errors')['file_upload']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <a href="<?= site_url('models') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to List
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Save Artifact
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>