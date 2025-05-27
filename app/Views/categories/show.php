<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?= esc($category['category_id']) ?></td></tr>
        <tr><th>Name</th><td><?= esc($category['name']) ?></td></tr>
        <tr><th>Description</th><td><?= esc($category['description']) ?></td></tr>
    </table>
    <a href="<?= site_url('categories') ?>" class="btn btn-secondary">Back to List</a>
</div>
<?= $this->endSection() ?> 