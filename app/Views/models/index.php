<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= esc($title) ?></h1>
        <a href="<?= site_url('artifacts/new') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New 3D Model
        </a>
    </div>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"> <?= session()->getFlashdata('error') ?> </div>
    <?php endif; ?>
    <table class="table table-striped table-hover table-bordered align-middle">
        <thead class="table-primary">
            <tr>
                <th>Title</th>
                <th>Artist</th>
                <th>Uploaded By</th>
                <th>Model File</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($artifacts)): ?>
            <tr><td colspan="6" class="text-center">No 3D models found. Upload your first model to get started!</td></tr>
        <?php else: ?>
            <?php foreach ($artifacts as $artifact): ?>
                <tr>
                    <td><?= esc($artifact['title']) ?></td>
                    <td><?= esc($artifact['artist_name']) ?></td>
                    <td><?= esc($artifact['user_name']) ?></td>
                    <td>
    <?php if (!empty($artifact['model_file_path'])): ?>
        <a href="<?= base_url('writable/' . $artifact['model_file_path']) ?>" target="_blank">
            <?= esc($artifact['model_file_path']) ?>
        </a>
    <?php else: ?>
        No file
    <?php endif; ?>
</td>
                    <td><?= esc($artifact['created_at']) ?></td>
                    <td>
                        <a href="<?= site_url('models/show/' . $artifact['artifact_id']) ?>" class="btn btn-outline-primary btn-sm">View</a>
                        <a href="<?= site_url('artifacts/edit/' . $artifact['artifact_id']) ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                        <form action="<?= site_url('models/delete/' . $artifact['artifact_id']) ?>" method="post" style="display:inline-block" onsubmit="return confirm('Delete this model?');">
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>


<?= $this->endSection() ?> 