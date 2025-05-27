<?php
/** @var array $artists */
/** @var string $title */
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <a href="<?= site_url('artists/new') ?>" class="btn btn-success mb-3">Add New Artist</a>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"> <?= session()->getFlashdata('error') ?> </div>
    <?php endif; ?>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Biography</th>
                <th>Municipality</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($artists as $artist): ?>
            <tr>
                <td><?= esc($artist['name']) ?></td>
                <td><?= esc($artist['biography']) ?></td>
                <td><?= esc($artist['municipality']) ?></td>
                <td><?= esc($artist['created_at']) ?></td>
                <td>
                    <a href="<?= site_url('artists/show/' . $artist['artist_id']) ?>" class="btn btn-info btn-sm">View</a>
                    <a href="<?= site_url('artists/edit/' . $artist['artist_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <form action="<?= site_url('artists/delete/' . $artist['artist_id']) ?>" method="post" style="display:inline-block" onsubmit="return confirm('Delete this artist?');">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?> 