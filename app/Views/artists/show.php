<?php
/** @var array $artist */
/** @var string $title */
?>

<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h1><?= esc($artist['name']) ?></h1>
    <dl class="row">
        <dt class="col-sm-3">Biography</dt>
        <dd class="col-sm-9"><?= esc($artist['biography']) ?></dd>
        <dt class="col-sm-3">Municipality</dt>
        <dd class="col-sm-9"><?= esc($artist['municipality']) ?></dd>
        <dt class="col-sm-3">Created At</dt>
        <dd class="col-sm-9"><?= esc($artist['created_at']) ?></dd>
    </dl>
    <a href="<?= site_url('artists') ?>" class="btn btn-secondary">Back to List</a>
    <a href="<?= site_url('artists/edit/' . $artist['artist_id']) ?>" class="btn btn-warning">Edit</a>
</div>
<?= $this->endSection() ?> 