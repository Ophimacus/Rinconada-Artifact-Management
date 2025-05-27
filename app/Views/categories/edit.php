<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <form action="<?= site_url('categories/update/' . $category['category_id']) ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= esc($category['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"><?= esc($category['description']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= site_url('categories') ?>" class="btn btn-secondary">Back to List</a>
    </form>
</div>
<?= $this->endSection() ?> 