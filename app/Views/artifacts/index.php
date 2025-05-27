<?php
/** @var array $artifacts */
/** @var string $title */
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <a href="<?= site_url('artifacts/new') ?>" class="btn btn-success mb-3">Add New Artifact</a>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"> <?= session()->getFlashdata('error') ?> </div>
    <?php endif; ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Category</th>
                <th>Uploaded By</th>
                <th>Municipality</th>
                <th>Model File</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($artifacts as $artifact): ?>
            <tr>
                <td><?= esc($artifact['title']) ?></td>
                <td><?= esc($artifact['artist_name']) ?></td>
                <td><?= esc($artifact['category_name']) ?></td>
                <td><?= esc($artifact['user_name']) ?></td>
                <td><?= esc($artifact['municipality']) ?></td>
                <td>
                    <?php if (!empty($artifact['model_file_path'])): ?>
                        <a href="<?= base_url(esc($artifact['model_file_path'])) ?>" target="_blank">Download File</a>
                    <?php else: ?>
                        No file
                    <?php endif; ?>
                </td>
                <td><?= esc($artifact['created_at']) ?></td>
                <td>
                    <a href="<?= site_url('artifacts/show/' . $artifact['artifact_id']) ?>" class="btn btn-info btn-sm">View</a>
                    <a href="<?= site_url('artifacts/edit/' . $artifact['artifact_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?= site_url('artifacts/delete/' . $artifact['artifact_id']) ?>" method="post" style="display:inline-block" onsubmit="return confirm('Delete this artifact?');">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?> 