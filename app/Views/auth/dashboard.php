<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - User Authentication</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg,rgb(0, 0, 0) 0%,rgb(0, 0, 0) 100%);
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(15, 33, 109, 0.1);
        }
        .card-header {
            background: linear-gradient(135deg,rgb(3, 1, 34) 0%,rgb(0, 1, 54) 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        .btn-danger {
            border-radius: 25px;
            padding: 8px 20px;
        }
        .welcome-card {
            background: linear-gradient(135deg,rgb(1, 9, 48) 0%,rgb(7, 0, 36) 100%);
            color: white;
        }
        .info-card {
            background: white;
            transition: transform 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('dashboard') ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>Welcome, <?= esc($user['name']) ?>!
                </span>
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </button>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Welcome Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card welcome-card">
                    <div class="card-body text-center py-5">
                        <h1 class="display-4 mb-3">
                            <i class="fas fa-home me-3"></i>Welcome to Your Dashboard
                        </h1>
                        <p class="lead mb-0">You have successfully logged in to your account!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Information Cards -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card info-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Full Name</h5>
                        <p class="card-text text-muted"><?= esc($user['name']) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card info-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-envelope fa-3x text-success"></i>
                        </div>
                        <h5 class="card-title">Email Address</h5>
                        <p class="card-text text-muted"><?= esc($user['email']) ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card info-card h-100">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-user-tag fa-3x text-warning"></i>
                        </div>
                        <h5 class="card-title">User Role</h5>
                        <p class="card-text text-muted">
                            <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : 'primary' ?> fs-6">
                                <?= ucfirst(esc($user['role'])) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-cogs me-2"></i>Account Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <button class="btn btn-outline-primary btn-lg" onclick="alert('Profile editing feature coming soon!')">
                                        <i class="fas fa-edit me-2"></i>Edit Profile
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-grid">
                                    <button class="btn btn-outline-secondary btn-lg" onclick="alert('Settings feature coming soon!')">
                                        <i class="fas fa-cog me-2"></i>Account Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <p class="text-muted mb-3">Ready to leave?</p>
                            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout Securely
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4 bg-light">
        <div class="container text-center">
            <p class="text-muted mb-0">
                <i class="fas fa-shield-alt me-1"></i>
                Secure Authentication System - Built with CodeIgniter 4
            </p>
        </div>
    </footer>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>Confirm Logout
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-question-circle fa-3x text-warning"></i>
                    </div>
                    <h5>Do you want to log out?</h5>
                    <p class="text-muted">You will be redirected to the home page and will need to log in again to access your dashboard.</p>
                    <small class="text-info"><i class="fas fa-info-circle me-1"></i>This confirmation appears when you try to navigate away from the dashboard.</small>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-lg me-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>No, Stay Here
                    </button>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-lg">
                        <i class="fas fa-check me-2"></i>Yes, Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Prevent browser back button from accessing dashboard after logout
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page was loaded from cache (back button)
                // Check if user is still logged in
                fetch('<?= base_url('dashboard') ?>', {
                    method: 'GET',
                    credentials: 'same-origin'
                }).then(response => {
                    if (response.redirected && response.url.includes('login')) {
                        // User is not logged in, redirect to login
                        window.location.href = '<?= base_url('login') ?>';
                    }
                });
            }
        });
        
        // Disable browser back button functionality when on dashboard
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            // Show the Bootstrap logout modal when trying to navigate back
            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
            
            // Prevent the back navigation by pushing state again
            history.pushState(null, null, location.href);
        };
    </script>
</body>
</html>
