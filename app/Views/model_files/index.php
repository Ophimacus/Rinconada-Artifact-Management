<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <a href="<?= site_url('model_files/create') ?>" class="btn btn-primary mb-3">Add New Model File</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Artifact ID</th>
                <th>File Name</th>
                <th>File Size (KB)</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model_files as $file): ?>
                <tr>
                    <td><?= esc($file['model_id']) ?></td>
                    <td><?= esc($file['artifact_id']) ?></td>
                    <td><?= esc($file['file_name']) ?></td>
                    <td><?= esc($file['file_size_kb']) ?></td>
                    <td><?= esc($file['uploaded_at']) ?></td>
                    <td>
                        <a href="<?= site_url('model_files/show/' . $file['model_id']) ?>" class="btn btn-info btn-sm">Show</a>
                        <a href="<?= site_url('model_files/edit/' . $file['model_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?= site_url('model_files/delete/' . $file['model_id']) ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?> 