<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Learning Management System' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            transform: translateY(-2px);
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .role-badge {
            font-size: 0.8rem;
            padding: 4px 12px;
            border-radius: 15px;
        }
    </style>
    <?= $additionalCSS ?? '' ?>
</head>
<body>
    <!-- Dynamic Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <i class="fas fa-graduation-cap me-2"></i>LMS
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Public Navigation Items -->
                    <?php if (!session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/') ?>">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('about') ?>">
                                <i class="fas fa-info-circle me-1"></i>About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('contact') ?>">
                                <i class="fas fa-envelope me-1"></i>Contact
                            </a>
                        </li>
                    <?php else: ?>
                        <!-- Authenticated User Navigation -->
                        <li class="nav-item">
                            <a class="nav-link <?= (current_url() == base_url('dashboard')) ? 'active' : '' ?>" 
                               href="<?= base_url('dashboard') ?>">
                                <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                            </a>
                        </li>
                        
                        <!-- Role-specific Navigation Items -->
                        <?php 
                        $userRole = session()->get('role');
                        if ($userRole === 'admin'): 
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cogs me-1"></i>Admin
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('admin/users') ?>">
                                        <i class="fas fa-users me-2"></i>User Management
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/courses') ?>">
                                        <i class="fas fa-book me-2"></i>Course Management
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                                        <i class="fas fa-cog me-2"></i>System Settings
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/reports') ?>">
                                        <i class="fas fa-chart-bar me-2"></i>Reports
                                    </a></li>
                                </ul>
                            </li>
                        <?php elseif ($userRole === 'teacher'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-chalkboard-teacher me-1"></i>Teacher
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/courses') ?>">
                                        <i class="fas fa-book me-2"></i>My Courses
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/students') ?>">
                                        <i class="fas fa-user-graduate me-2"></i>Students
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/assignments') ?>">
                                        <i class="fas fa-tasks me-2"></i>Assignments
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/grades') ?>">
                                        <i class="fas fa-star me-2"></i>Grades
                                    </a></li>
                                </ul>
                            </li>
                        <?php elseif ($userRole === 'student'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-graduation-cap me-1"></i>Student
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('student/courses') ?>">
                                        <i class="fas fa-book-open me-2"></i>My Courses
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('student/assignments') ?>">
                                        <i class="fas fa-clipboard-list me-2"></i>Assignments
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('student/grades') ?>">
                                        <i class="fas fa-graduation-cap me-2"></i>Grades
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('student/schedule') ?>">
                                        <i class="fas fa-calendar-alt me-2"></i>Schedule
                                    </a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                
                <!-- User Authentication Section -->
                <ul class="navbar-nav">
                    <?php if (!session()->get('isLoggedIn')): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">
                                <i class="fas fa-sign-in-alt me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('register') ?>">
                                <i class="fas fa-user-plus me-1"></i>Register
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?= esc(session()->get('name')) ?>
                                <span class="role-badge bg-light text-dark ms-2">
                                    <?= ucfirst(esc(session()->get('role'))) ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>">
                                    <i class="fas fa-user me-2"></i>Profile
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('settings') ?>">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
