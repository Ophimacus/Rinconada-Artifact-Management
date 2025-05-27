<?php
/** @var array $artist */
/** @var string $title */
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($title) ?></h1>
    <?php if (isset($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= site_url('artists/update/' . $artist['artist_id']) ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?= old('name', $artist['name']) ?>">
        </div>
        <div class="mb-3">
            <label for="biography" class="form-label">Biography</label>
            <textarea class="form-control" id="biography" name="biography"><?= old('biography', $artist['biography']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="municipality" class="form-label">Municipality</label>
            <input type="text" class="form-control" id="municipality" name="municipality" value="<?= old('municipality', $artist['municipality']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Update Artist</button>
        <a href="<?= site_url('artists') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?= $this->endSection() ?> 