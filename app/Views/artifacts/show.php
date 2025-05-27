<?php
/** @var array $artifact */
/** @var string $title */
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($artifact['title']) ?></h1>
    <div class="row">
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">3D Model Preview</h5>
                    <?php if (!empty($artifact['model_file_path'])): ?>
                        <!-- Example: Embed a 3D viewer or show a download link -->
                        <model-viewer src="<?= base_url(esc($artifact['model_file_path'])) ?>" alt="3D Model" auto-rotate camera-controls style="width:100%;height:300px;"></model-viewer>
                        <p class="mt-2"><a href="<?= base_url(esc($artifact['model_file_path'])) ?>" target="_blank">Download Model</a></p>
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height:300px;">
                            <i class="fa fa-cube fa-4x text-secondary"></i>
                        </div>
                        <p class="mt-2 text-muted">No 3D model file available.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <dl class="row">
                <dt class="col-sm-4">Description</dt>
                <dd class="col-sm-8"><?= esc($artifact['description']) ?></dd>
                <dt class="col-sm-4">Origin</dt>
                <dd class="col-sm-8"><?= esc($artifact['origin']) ?></dd>
                <dt class="col-sm-4">Municipality</dt>
                <dd class="col-sm-8"><?= esc($artifact['municipality']) ?></dd>
                <dt class="col-sm-4">Category</dt>
                <dd class="col-sm-8"><?= esc($artifact['category_name']) ?></dd>
                <dt class="col-sm-4">Artist</dt>
                <dd class="col-sm-8"><?= esc($artifact['artist_name']) ?></dd>
                <dt class="col-sm-4">Uploaded By</dt>
                <dd class="col-sm-8"><?= esc($artifact['user_name']) ?></dd>
                <dt class="col-sm-4">Created At</dt>
                <dd class="col-sm-8"><?= esc($artifact['created_at']) ?></dd>
                <?php if (!empty($artifact['model_file_path'])): ?>
                    <dt class="col-sm-4">Model File Path</dt>
                    <dd class="col-sm-8"><a href="<?= base_url(esc($artifact['model_file_path'])) ?>" target="_blank"><?= esc($artifact['model_file_path']) ?></a></dd>
                <?php endif; ?>
            </dl>
        </div>
    </div>
    <a href="<?= site_url('artifacts') ?>" class="btn btn-secondary">Back to List</a>
    <a href="<?= site_url('artifacts/edit/' . $artifact['artifact_id']) ?>" class="btn btn-warning">Edit</a>
</div>
<!-- 3D Model Viewer Polyfill (if needed) -->
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
<?= $this->endSection() ?> 