<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <form action="<?= site_url('models/update/' . $artifact['artifact_id']) ?>" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= esc($artifact['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"><?= esc($artifact['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="origin" class="form-label">Origin</label>
            <input type="text" class="form-control" id="origin" name="origin" value="<?= esc($artifact['origin']) ?>">
        </div>
        <div class="mb-3">
            <label for="municipality" class="form-label">Municipality</label>
            <input type="text" class="form-control" id="municipality" name="municipality" value="<?= esc($artifact['municipality']) ?>">
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category['category_id']) ?>" <?= $category['category_id'] == $artifact['category_id'] ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="artist_id" class="form-label">Artist</label>
            <select class="form-control" id="artist_id" name="artist_id" required>
                <option value="">Select Artist</option>
                <?php foreach ($artists as $artist): ?>
                    <option value="<?= esc($artist['artist_id']) ?>" <?= $artist['artist_id'] == $artifact['artist_id'] ? 'selected' : '' ?>><?= esc($artist['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <?php if (isset($user['user_id'])): ?>
                        <option value="<?= esc($user['user_id']) ?>" <?= $user['user_id'] == $artifact['user_id'] ? 'selected' : '' ?>><?= esc($user['username']) ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="created_at" class="form-label">Created At</label>
            <input type="datetime-local" class="form-control" id="created_at" name="created_at" value="<?= esc($artifact['created_at']) ?>">
        </div>
        <div class="mb-3">
            <label for="file_name" class="form-label">File Name</label>
            <input type="text" class="form-control" id="file_name" name="file_name" value="<?= esc(old('file_name', $file_name ?? '')) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="<?= site_url('models') ?>" class="btn btn-secondary">Back to List</a>
    </form>
</div>
<?= $this->endSection() ?> 