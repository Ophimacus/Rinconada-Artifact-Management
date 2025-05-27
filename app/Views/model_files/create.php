<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <form action="<?= site_url('model_files/store') ?>" method="post">
        <div class="mb-3">
            <label for="artifact_id" class="form-label">Artifact ID</label>
            <input type="number" class="form-control" id="artifact_id" name="artifact_id" required>
        </div>
        <div class="mb-3">
            <label for="file_name" class="form-label">File Name</label>
            <input type="text" class="form-control" id="file_name" name="file_name" required>
        </div>
        <div class="mb-3">
            <label for="file_size_kb" class="form-label">File Size (KB)</label>
            <input type="number" class="form-control" id="file_size_kb" name="file_size_kb" required>
        </div>
        <div class="mb-3">
            <label for="uploaded_at" class="form-label">Uploaded At</label>
            <input type="datetime-local" class="form-control" id="uploaded_at" name="uploaded_at">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
        <a href="<?= site_url('model_files') ?>" class="btn btn-secondary">Back to List</a>
    </form>
</div>
<?= $this->endSection() ?> 