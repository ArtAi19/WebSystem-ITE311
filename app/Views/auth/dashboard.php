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
        /* Ensure modal appears properly */
        .modal {
            z-index: 9999 !important;
        }
        .modal-backdrop {
            z-index: 9998 !important;
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

    <!-- Immediate back button prevention -->
    <script>
        // Disable back button immediately
        (function() {
            history.pushState(null, null, location.href);
            window.addEventListener('popstate', function() {
                history.pushState(null, null, location.href);
                // Show logout modal with better error handling
                setTimeout(function() {
                    try {
                        const modalElement = document.getElementById('logoutModal');
                        if (modalElement) {
                            const logoutModal = new bootstrap.Modal(modalElement);
                            logoutModal.show();
                        } else {
                            // Fallback: direct confirmation
                            if (confirm('Do you want to log out?')) {
                                window.location.href = '<?= base_url('logout') ?>';
                            }
                        }
                    } catch (error) {
                        // Fallback: direct confirmation
                        if (confirm('Do you want to log out?')) {
                            window.location.href = '<?= base_url('logout') ?>';
                        }
                    }
                }, 200);
            });
        })();
    </script>

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
                        <p class="lead mb-3">You have successfully logged in to your account!</p>
                        <div class="text-center">
                            <span class="badge bg-light text-dark fs-6 px-3 py-2">
                                <i class="fas fa-user-tag me-2"></i>Current Role: 
                                <strong><?= !empty($user['role']) ? ucfirst(esc($user['role'])) : 'Not Set' ?></strong>
                            </span>
                        </div>
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
                            <?php if (!empty($user['role'])): ?>
                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'teacher' ? 'warning' : 'primary') ?> fs-6">
                                    <?= ucfirst(esc($user['role'])) ?>
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary fs-6">No Role Set</span>
                                <!-- Debug info -->
                                <small class="d-block mt-1 text-danger">
                                    Debug: Role = "<?= esc($user['role'] ?? 'NULL') ?>"
                                </small>
                            <?php endif; ?>
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
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>Confirm Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-question-circle fa-3x text-warning"></i>
                    </div>
                    <h5>Do you want to log out?</h5>
                    <p class="text-muted">You will be signed out of your account and redirected to the home page.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-lg me-3" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>No
                    </button>
                    <a href="<?= base_url('logout') ?>" class="btn btn-danger btn-lg">
                        <i class="fas fa-check me-2"></i>Yes
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
        
        // Additional back button prevention (backup)
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure modal is properly initialized
            const modalElement = document.getElementById('logoutModal');
            if (modalElement) {
                // Test that modal works
                console.log('Logout modal found and ready');
            }
        });
    </script>
</body>
</html>
