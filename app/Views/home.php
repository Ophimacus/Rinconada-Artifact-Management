<?php
/**
 * Rinconada Artifact Server - CMS Style Homepage
 * Shows dashboard-style summary and tables for Artifacts, Artists, and quick stats.
 *
 * @var array $artifacts
 * @var array $artists
 * @var string $title
 */
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold mb-0">Welcome to Rinconada 3D Art Content Management System</h1>
            <p class="lead">Manage, browse, and explore all artifacts, artists, and 3D models in one place.</p>
        </div>
        <div class="col-md-4 text-end align-self-center">
            <a href="<?= site_url('artifacts/new') ?>" class="btn btn-primary btn-lg"><i class="fas fa-plus"></i> Add New Artifact</a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Artifacts</h5>
                    <p class="display-6 fw-bold mb-0"><?= count($artifacts) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Artists</h5>
                    <p class="display-6 fw-bold mb-0"><?= count($artists) ?></p>
                </div>
            </div>
        </div>
        <!-- Add more stats here if needed -->
    </div>

    <!-- Artifacts Table -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Artifacts Overview</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Category</th>
                            <th>Municipality</th>
                            <th>Model File</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_slice($artifacts, 0, 5) as $artifact): ?>
                        <tr>
                            <td><?= esc($artifact['title']) ?></td>
                            <td><?= esc($artifact['artist_name']) ?></td>
                            <td><?= esc($artifact['category_name'] ?? '-') ?></td>
                            <td><?= esc($artifact['municipality'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($artifact['model_file_path'])): ?>
                                    <?= esc($artifact['model_file_path']) ?>
                                <?php else: ?>
                                    <span class="text-muted">No file</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($artifact['created_at']) ?></td>
                            <td>
                                <a href="<?= site_url('artifacts/show/' . $artifact['artifact_id']) ?>" class="btn btn-outline-info btn-sm">View</a>
                                <a href="<?= site_url('artifacts/edit/' . $artifact['artifact_id']) ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 text-end">
                <a href="<?= site_url('artifacts') ?>" class="btn btn-link">View All Artifacts &raquo;</a>
            </div>
        </div>
    </div>

    <!-- Artists Table -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Artists Overview</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Municipality</th>
                            <th>Biography</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach (array_slice($artists, 0, 5) as $artist): ?>
                        <tr>
                            <td><?= esc($artist['name']) ?></td>
                            <td><?= esc($artist['municipality'] ?? '-') ?></td>
                            <td><?= esc($artist['biography'] ?? '-') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3 text-end">
                <a href="<?= site_url('artists') ?>" class="btn btn-link">View All Artists &raquo;</a>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 0.75rem;
}
.card-header {
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
}
</style>
<?= $this->endSection() ?>
