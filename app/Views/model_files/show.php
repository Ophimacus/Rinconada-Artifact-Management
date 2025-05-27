<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?= esc($model_file['model_id']) ?></td></tr>
        <tr><th>Artifact ID</th><td><?= esc($model_file['artifact_id']) ?></td></tr>
        <tr><th>File Name</th><td><?= esc($model_file['file_name']) ?></td></tr>
        <tr><th>File Size (KB)</th><td><?= esc($model_file['file_size_kb']) ?></td></tr>
        <tr><th>Uploaded At</th><td><?= esc($model_file['uploaded_at']) ?></td></tr>
    </table>
    <a href="<?= site_url('model_files') ?>" class="btn btn-secondary">Back to List</a>
</div>
<?= $this->endSection() ?> 