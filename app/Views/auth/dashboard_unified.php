<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Learning Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .sidebar {
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            min-height: calc(100vh - 76px);
            box-shadow: 2px 0 5px rgba(0,0,0,.1);
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 10px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(52, 152, 219, 0.2);
            color: #3498db;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: #3498db;
            color: white;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            font-weight: 600;
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stats-card.admin {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
        .stats-card.teacher {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }
        .stats-card.student {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .role-badge {
            font-size: 0.9rem;
            padding: 8px 16px;
            border-radius: 20px;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="<?= base_url('dashboard') ?>">
                <i class="fas fa-graduation-cap me-2"></i>LMS Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>Welcome, <?= esc($user['name']) ?>!
                    <span class="role-badge bg-light text-dark ms-2">
                        <?= ucfirst(esc($user['role'])) ?>
                    </span>
                </span>
                <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#logoutModal">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </button>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Navigation -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <div class="p-3">
                        <h6 class="text-light mb-3">
                            <i class="fas fa-bars me-2"></i>Navigation
                        </h6>
                        <nav class="nav flex-column">
                            <!-- Common Navigation Items -->
                            <?php foreach ($navigationItems['common'] as $item): ?>
                                <a class="nav-link <?= (current_url() == base_url($item['url'])) ? 'active' : '' ?>" 
                                   href="<?= base_url($item['url']) ?>">
                                    <i class="<?= $item['icon'] ?> me-2"></i><?= $item['name'] ?>
                                </a>
                            <?php endforeach; ?>
                            
                            <!-- Role-specific Navigation Items -->
                            <?php if (!empty($navigationItems['role_specific'])): ?>
                                <hr class="text-light my-3">
                                <h6 class="text-light mb-3">
                                    <i class="fas fa-user-tag me-2"></i><?= ucfirst($user['role']) ?> Tools
                                </h6>
                                <?php foreach ($navigationItems['role_specific'] as $item): ?>
                                    <a class="nav-link" href="<?= base_url($item['url']) ?>">
                                        <i class="<?= $item['icon'] ?> me-2"></i><?= $item['name'] ?>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <!-- Flash Messages -->
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

                    <!-- Welcome Section -->
                    <div class="welcome-section">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h1 class="display-5 fw-bold mb-2">
                                    <i class="fas fa-home me-3"></i>Welcome back, <?= esc($user['name']) ?>!
                                </h1>
                                <p class="lead mb-3">
                                    You're logged in as a <strong><?= ucfirst(esc($user['role'])) ?></strong>. 
                                    Here's your personalized dashboard.
                                </p>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-light text-dark fs-6 px-3 py-2">
                                        <i class="fas fa-user-tag me-2"></i>Current Role: <strong><?= ucfirst(esc($user['role'])) ?></strong>
                                    </span>
                                    <a href="<?= base_url('dashboard?type=original') ?>" class="btn btn-outline-light btn-sm">
                                        <i class="fas fa-exchange-alt me-1"></i>Switch to Original Dashboard
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <i class="fas fa-user-circle fa-5x opacity-50"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Role-specific Dashboard Content -->
                    <?php if ($user['role'] === 'admin'): ?>
                        <!-- Admin Dashboard -->
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="card stats-card admin">
                                    <div class="card-body text-center">
                                        <i class="fas fa-users fa-2x mb-2"></i>
                                        <h3 class="fw-bold"><?= $roleData['totalUsers'] ?? 0 ?></h3>
                                        <p class="mb-0">Total Users</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card stats-card admin">
                                    <div class="card-body text-center">
                                        <i class="fas fa-chalkboard-teacher fa-2x mb-2"></i>
                                        <h3 class="fw-bold"><?= $roleData['totalTeachers'] ?? 0 ?></h3>
                                        <p class="mb-0">Teachers</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card stats-card admin">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                        <h3 class="fw-bold"><?= $roleData['totalStudents'] ?? 0 ?></h3>
                                        <p class="mb-0">Students</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card stats-card admin">
                                    <div class="card-body text-center">
                                        <i class="fas fa-book fa-2x mb-2"></i>
                                        <h3 class="fw-bold">0</h3>
                                        <p class="mb-0">Courses</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Users -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Users</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($roleData['recentUsers'])): ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Joined</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($roleData['recentUsers'] as $recentUser): ?>
                                                    <tr>
                                                        <td><?= esc($recentUser->name) ?></td>
                                                        <td><?= esc($recentUser->email) ?></td>
                                                        <td>
                                                            <span class="badge bg-<?= $recentUser->role === 'admin' ? 'danger' : ($recentUser->role === 'teacher' ? 'warning' : 'primary') ?>">
                                                                <?= ucfirst($recentUser->role) ?>
                                                            </span>
                                                        </td>
                                                        <td><?= date('M j, Y', strtotime($recentUser->created_at)) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php else: ?>
                                    <p class="text-muted">No recent users found.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php elseif ($user['role'] === 'teacher'): ?>
                        <!-- Teacher Dashboard -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <div class="card stats-card teacher">
                                    <div class="card-body text-center">
                                        <i class="fas fa-book fa-2x mb-2"></i>
                                        <h3 class="fw-bold"><?= $roleData['totalCourses'] ?? 0 ?></h3>
                                        <p class="mb-0">My Courses</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card stats-card teacher">
                                    <div class="card-body text-center">
                                        <i class="fas fa-users fa-2x mb-2"></i>
                                        <h3 class="fw-bold"><?= $roleData['totalStudents'] ?? 0 ?></h3>
                                        <p class="mb-0">Students</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card stats-card teacher">
                                    <div class="card-body text-center">
                                        <i class="fas fa-tasks fa-2x mb-2"></i>
                                        <h3 class="fw-bold">0</h3>
                                        <p class="mb-0">Assignments</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-chalkboard-teacher me-2"></i>Teacher Dashboard</h5>
                            </div>
                            <div class="card-body">
                                <p>Welcome to your teacher dashboard! Here you can manage your courses, students, and assignments.</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Quick Actions:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-plus text-success me-2"></i>Create new course</li>
                                            <li><i class="fas fa-edit text-primary me-2"></i>Grade assignments</li>
                                            <li><i class="fas fa-users text-info me-2"></i>View student progress</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Recent Activity:</h6>
                                        <p class="text-muted">No recent activity to display.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($user['role'] === 'student'): ?>
                        <!-- Student Dashboard -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <div class="card stats-card student">
                                    <div class="card-body text-center">
                                        <i class="fas fa-book-open fa-2x mb-2"></i>
                                        <h3 class="fw-bold"><?= $roleData['enrolledCourses'] ?? 0 ?></h3>
                                        <p class="mb-0">Enrolled Courses</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card stats-card student">
                                    <div class="card-body text-center">
                                        <i class="fas fa-check-circle fa-2x mb-2"></i>
                                        <h3 class="fw-bold"><?= $roleData['completedAssignments'] ?? 0 ?></h3>
                                        <p class="mb-0">Completed</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card stats-card student">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clock fa-2x mb-2"></i>
                                        <h3 class="fw-bold">0</h3>
                                        <p class="mb-0">Pending</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Student Dashboard</h5>
                            </div>
                            <div class="card-body">
                                <p>Welcome to your student dashboard! Here you can access your courses, assignments, and track your progress.</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Quick Access:</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-book text-primary me-2"></i>View courses</li>
                                            <li><i class="fas fa-clipboard-list text-warning me-2"></i>Check assignments</li>
                                            <li><i class="fas fa-star text-success me-2"></i>View grades</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>Upcoming Deadlines:</h6>
                                        <p class="text-muted">No upcoming deadlines.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Default User Dashboard -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>User Dashboard</h5>
                            </div>
                            <div class="card-body">
                                <p><?= $roleData['message'] ?? 'Welcome to your dashboard!' ?></p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-user fa-2x text-primary mb-2"></i>
                                                <h6>Profile</h6>
                                                <p class="small text-muted">Manage your account</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-cog fa-2x text-secondary mb-2"></i>
                                                <h6>Settings</h6>
                                                <p class="small text-muted">Configure preferences</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fas fa-question-circle fa-2x text-info mb-2"></i>
                                                <h6>Help</h6>
                                                <p class="small text-muted">Get support</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

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
                    <h5>Are you sure you want to log out?</h5>
                    <p class="text-muted">You will be redirected to the home page and will need to log in again to access your dashboard.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-lg me-2" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
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
                fetch('<?= base_url('dashboard') ?>', {
                    method: 'GET',
                    credentials: 'same-origin'
                }).then(response => {
                    if (response.redirected && response.url.includes('login')) {
                        window.location.href = '<?= base_url('login') ?>';
                    }
                });
            }
        });
        
        // Disable browser back button functionality when on dashboard
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            const logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
            history.pushState(null, null, location.href);
        };
    </script>
</body>
</html>
