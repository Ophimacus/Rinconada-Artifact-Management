<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <a href="<?= site_url('categories/create') ?>" class="btn btn-primary mb-3">Add New Category</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= esc($category['category_id']) ?></td>
                    <td><?= esc($category['name']) ?></td>
                    <td><?= esc($category['description']) ?></td>
                    <td>
                        <a href="<?= site_url('categories/show/' . $category['category_id']) ?>" class="btn btn-info btn-sm">Show</a>
                        <a href="<?= site_url('categories/edit/' . $category['category_id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <form action="<?= site_url('categories/delete/' . $category['category_id']) ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?> 