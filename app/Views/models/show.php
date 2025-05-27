<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('models') ?>">3D Models</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($artifact['title']) ?></li>
        </ol>
    </nav>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0"><?= esc($artifact['title']) ?></h2>
            <div>
                <a href="<?= site_url('models/edit/' . $artifact['artifact_id']) ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="<?= site_url('models') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <?php if (!empty($artifact['file_path'])): ?>
                        <div class="border rounded p-3" style="background-color: #f8f9fa;">
                            <?php if (in_array(pathinfo($artifact['file_path'], PATHINFO_EXTENSION), ['glb', 'gltf'])): ?>
                                <model-viewer 
                                    src="<?= base_url('writable/' . $artifact['file_path']) ?>" 
                                    alt="<?= esc($artifact['title']) ?>"
                                    auto-rotate 
                                    camera-controls
                                    shadow-intensity="1"
                                    camera-orbit="45deg 60deg 100%"
                                    style="width: 100%; height: 500px;"
                                >
                                    <div class="progress" style="height: 4px; margin: 10px 0;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%;"></div>
                                    </div>
                                </model-viewer>
                                <div class="text-center mt-2">
                                    <a href="<?= base_url('writable/' . $artifact['file_path']) ?>" class="btn btn-sm btn-outline-primary" download>
                                        <i class="fas fa-download"></i> Download Model
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center p-5">
                                    <i class="fas fa-file-archive fa-5x text-muted mb-3"></i>
                                    <p class="mb-0">3D model preview not available for this file type</p>
                                    <a href="<?= base_url('writable/' . $artifact['file_path']) ?>" class="btn btn-sm btn-outline-primary mt-3" download>
                                        <i class="fas fa-download"></i> Download Model
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">No 3D model file available for this artifact.</div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Artifact Details</h5>
                        </div>
                        <div class="card-body">
                            <dl class="mb-0">
                                <?php if (!empty($artifact['description'])): ?>
                                    <dt>Description</dt>
                                    <dd class="mb-3"><?= nl2br(esc($artifact['description'])) ?></dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($artifact['artist_name'])): ?>
                                    <dt>Artist</dt>
                                    <dd class="mb-3"><?= esc($artifact['artist_name']) ?></dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($artifact['origin'])): ?>
                                    <dt>Origin</dt>
                                    <dd class="mb-3"><?= esc($artifact['origin']) ?></dd>
                                <?php endif; ?>
                                
                                <?php if (!empty($artifact['municipality'])): ?>
                                    <dt>Municipality</dt>
                                    <dd class="mb-3"><?= esc($artifact['municipality']) ?></dd>
                                <?php endif; ?>
                                
                                <dt>Created</dt>
                                <dd class="mb-0"><?= date('F j, Y', strtotime($artifact['created_at'])) ?></dd>
                            </dl>
                        </div>
                    </div>
                    
                    <?php if (!empty($artifact['file_name'])): ?>
                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">File Information</h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-1"><strong>Filename:</strong> <?= esc($artifact['file_name']) ?></p>
                                <?php if (!empty($artifact['file_size_kb'])): ?>
                                    <p class="mb-1"><strong>Size:</strong> <?= number_format($artifact['file_size_kb'] / 1024, 2) ?> MB</p>
                                <?php endif; ?>
                                <p class="mb-0"><strong>Type:</strong> .<?= strtoupper(pathinfo($artifact['file_path'], PATHINFO_EXTENSION)) ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load model-viewer component -->
<script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.3.0/model-viewer.min.js"></script>

<style>
    model-viewer {
        --progress-bar-color: #3498db;
        --progress-bar-height: 4px;
        --progress-mask: #f8f9fa;
    }
    .card {
        border: 1px solid rgba(0,0,0,.125);
    }
    dt {
        font-weight: 600;
        color: #6c757d;
    }
    dd {
        margin-bottom: 0.5rem;
    }
</style>

<?= $this->endSection() ?>