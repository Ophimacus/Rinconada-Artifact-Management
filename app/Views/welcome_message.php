<?php
/** @var array $artifacts */
/** @var array $artists */
/** @var string $title */
?>

<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
    <div class="container mt-4">
        <h1><?= esc($title) ?></h1>
        <h2 class="mt-5">3D Models</h2>
        <div class="row">
            <?php foreach ($artifacts as $artifact): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                            <i class="fa fa-cube fa-4x text-secondary"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($artifact['title']) ?></h5>
                            <p class="card-text"><?= esc($artifact['description']) ?></p>
                            <p class="card-text"><small class="text-muted">Artist: <?= esc($artifact['artist_name']) ?></small></p>
                            <a href="<?= site_url('artifacts/show/' . $artifact['artifact_id']) ?>" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <h2 class="mt-5">Artists</h2>
        <div class="row">
            <?php foreach ($artists as $artist): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($artist['name']) ?></h5>
                            <p class="card-text"><?= esc($artist['biography']) ?></p>
                            <p class="card-text"><small class="text-muted">Municipality: <?= esc($artist['municipality']) ?></small></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<style>
    .model-card, .artist-card {
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .model-card:hover, .artist-card:hover {
        transform: translateY(-5px);
    }
</style>
<?= $this->endSection() ?>
