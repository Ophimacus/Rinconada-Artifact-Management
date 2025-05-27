<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Rinconada 3D Art Repository') ?></title>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .btn-group form {
            display: inline-block;
        }
        .btn-group form button {
            border-radius: 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url() ?>">Rinconada 3D Art</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('artifacts') ?>">Artifacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('categories') ?>">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('models') ?>">Models</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('artists') ?>">Artists</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <!-- Auth links removed: Add User, Logout, Login -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Rinconada 3D Art Repository</h5>
                    <p>A digital archive of historical artifacts and artworks</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; <?= date('Y') ?> All rights reserved</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Set up CSRF token for AJAX requests
        document.addEventListener('DOMContentLoaded', function() {
            // Add CSRF token to all forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                if (!form.querySelector('input[name="<?= csrf_token() ?>"], input[name="_csrf"]')) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '<?= csrf_token() ?>';
                    csrfInput.value = '<?= csrf_hash() ?>';
                    form.appendChild(csrfInput);
                }
            });
            
            // Handle form submissions
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.tagName === 'FORM' && form.method.toLowerCase() === 'post') {
                    // Add loading state
                    const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
                    }
                }
            });
        });
    </script>
</body>
</html>