<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = \Config\Services::session();
    }

    /**
     * Display the registration form and process form submission
     */
    public function register()
    {
        // Check if form was submitted (POST request)
        if ($this->request->getMethod() === 'POST') {
            // Set validation rules for the form fields
            $validation = \Config\Services::validation();
            $validation->setRules([
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'role' => 'required|in_list[student,teacher,admin]',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ]);

            // Debug: Check what role was submitted
            $submittedRole = $this->request->getPost('role');
            log_message('info', 'Form submitted with role: ' . ($submittedRole ?? 'NULL'));

            // If validation passes, hash the password using password_hash()
            if ($validation->withRequest($this->request)->run()) {
                $name = $this->request->getPost('name');
                $email = $this->request->getPost('email');
                $role = $this->request->getPost('role');
                $password = $this->request->getPost('password');
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Save the user data (name, email, hashed_password, role) to the users table
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => $role,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Debug: Log what we're trying to insert
                log_message('info', 'Registration attempt - Role selected: ' . $role);
                log_message('info', 'Registration data: ' . json_encode($data));

                $builder = $this->db->table('users');
                
                try {
                    if ($builder->insert($data)) {
                        // Verify what was actually inserted
                        $insertedId = $this->db->insertID();
                        $insertedUser = $builder->where('id', $insertedId)->get()->getRow();
                        log_message('info', 'User inserted with ID: ' . $insertedId . ', Role in DB: ' . ($insertedUser->role ?? 'NULL'));
                        
                        // On success, set a flash message and redirect to the login page
                        $this->session->setFlashdata('success', 'Account registered successfully as ' . ucfirst($role) . '! Please login.');
                        return redirect()->to(base_url('login'));
                    } else {
                        $this->session->setFlashdata('error', 'Registration failed. Please try again.');
                    }
                } catch (\Exception $e) {
                    $this->session->setFlashdata('error', 'Database error: ' . $e->getMessage());
                    log_message('error', 'Registration error: ' . $e->getMessage());
                }
            } else {
                $this->session->setFlashdata('error', 'Please fix the validation errors.');
                $data['validation'] = $validation;
            }
        }

        // Load a view (app/Views/auth/register.php) that contains a Bootstrap-styled registration form
        return view('auth/register', $data ?? []);
    }

    /**
     * Display the login form and process form submission
     */
    public function login()
    {
        // Check for a POST request
        if ($this->request->getMethod() === 'POST') {
            // Set validation rules for email and password
            $validation = \Config\Services::validation();
            $validation->setRules([
                'email' => 'required|valid_email',
                'password' => 'required'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');

                try {
                    // If validation passes, check the database for a user using the provided email
                    $builder = $this->db->table('users');
                    $user = $builder->where('email', $email)->get()->getRow();

                    if ($user) {
                        // Verify the submitted password against the stored hash using password_verify()
                        if (password_verify($password, $user->password)) {
                            // If credentials are correct, create a user session (store: userID, name, email, role)
                            $sessionData = [
                                'userID' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email,
                                'role' => $user->role,
                                'isLoggedIn' => true
                            ];
                            $this->session->set($sessionData);

                            // Set a welcome flash message and redirect to the dashboard
                            $this->session->setFlashdata('success', 'Welcome back, ' . $user->name . '!');
                            return redirect()->to(base_url('dashboard'));
                        }
                    }
                    
                    $this->session->setFlashdata('error', 'Invalid email or password.');
                } catch (\Exception $e) {
                    $this->session->setFlashdata('error', 'Database error: ' . $e->getMessage());
                    log_message('error', 'Login error: ' . $e->getMessage());
                }
            } else {
                $this->session->setFlashdata('error', 'Please fix the validation errors.');
                $data['validation'] = $validation;
            }
        }

        // Load a view (app/Views/auth/login.php) that contains a Bootstrap-styled login form
        return view('auth/login', $data ?? []);
    }

    /**
     * Destroy the user's session and redirect them
     */
    public function logout()
    {
        // Destroy the current session using session()->destroy()
        $this->session->destroy();
        
        // Redirect the user to the homepage
        return redirect()->to(base_url('/'))->with('success', 'You have been logged out successfully.');
    }

    /**
     * A protected page that only logged-in users can see
     * Enhanced to support role-based dashboard functionality
     */
    public function dashboard()
    {
        // Check if a user is logged in at the start of the method. If not, redirect them to the login page
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login to access the dashboard.');
        }

        // Get user role and fetch role-specific data
        $userRole = $this->session->get('role');
        $userId = $this->session->get('userID');
        
        // If no role in session, fetch from database
        if (empty($userRole) && $userId) {
            try {
                $builder = $this->db->table('users');
                $user = $builder->where('id', $userId)->get()->getRow();
                if ($user && !empty($user->role)) {
                    $userRole = $user->role;
                    // Update session with the role
                    $this->session->set('role', $userRole);
                }
            } catch (\Exception $e) {
                log_message('error', 'Error fetching user role: ' . $e->getMessage());
            }
        }
        
        // Default role if still empty
        if (empty($userRole)) {
            $userRole = 'user';
        }
        
        // Fetch role-specific data from database
        $roleData = $this->getRoleSpecificData($userRole, $userId);
        
        $data = [
            'user' => [
                'id' => $this->session->get('userID'),
                'name' => $this->session->get('name'),
                'email' => $this->session->get('email'),
                'role' => $userRole
            ],
            'roleData' => $roleData,
            'navigationItems' => $this->getNavigationItems($userRole)
        ];

        // Always use the original dashboard with role information
        $originalData = [
            'user' => [
                'name' => $this->session->get('name'),
                'email' => $this->session->get('email'),
                'role' => $userRole
            ]
        ];
        return view('auth/dashboard', $originalData);
    }

    /**
     * Get role-specific data for the dashboard
     */
    private function getRoleSpecificData($role, $userId)
    {
        $data = [];
        
        try {
            switch ($role) {
                case 'admin':
                    // Admin-specific data
                    $builder = $this->db->table('users');
                    $data['totalUsers'] = $builder->countAll();
                    $data['totalTeachers'] = $builder->where('role', 'teacher')->countAllResults(false);
                    $data['totalStudents'] = $builder->where('role', 'student')->countAllResults(false);
                    $data['recentUsers'] = $builder->orderBy('created_at', 'DESC')->limit(5)->get()->getResult();
                    break;
                    
                case 'teacher':
                    // Teacher-specific data
                    $data['totalCourses'] = 0; // Placeholder - implement when courses table exists
                    $data['totalStudents'] = 0; // Placeholder - implement when enrollments exist
                    $data['recentActivity'] = []; // Placeholder
                    break;
                    
                case 'student':
                    // Student-specific data
                    $data['enrolledCourses'] = 0; // Placeholder - implement when enrollments exist
                    $data['completedAssignments'] = 0; // Placeholder
                    $data['upcomingDeadlines'] = []; // Placeholder
                    break;
                    
                default:
                    // Default user data
                    $data['message'] = 'Welcome to your dashboard!';
                    break;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error fetching role-specific data: ' . $e->getMessage());
            $data['error'] = 'Unable to load dashboard data';
        }
        
        return $data;
    }

    /**
     * Get navigation items based on user role
     */
    private function getNavigationItems($role)
    {
        $items = [
            'common' => [
                ['name' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'fas fa-tachometer-alt'],
                ['name' => 'Profile', 'url' => 'profile', 'icon' => 'fas fa-user']
            ]
        ];
        
        switch ($role) {
            case 'admin':
                $items['role_specific'] = [
                    ['name' => 'User Management', 'url' => 'admin/users', 'icon' => 'fas fa-users'],
                    ['name' => 'Course Management', 'url' => 'admin/courses', 'icon' => 'fas fa-book'],
                    ['name' => 'System Settings', 'url' => 'admin/settings', 'icon' => 'fas fa-cogs'],
                    ['name' => 'Reports', 'url' => 'admin/reports', 'icon' => 'fas fa-chart-bar']
                ];
                break;
                
            case 'teacher':
                $items['role_specific'] = [
                    ['name' => 'My Courses', 'url' => 'teacher/courses', 'icon' => 'fas fa-chalkboard-teacher'],
                    ['name' => 'Students', 'url' => 'teacher/students', 'icon' => 'fas fa-user-graduate'],
                    ['name' => 'Assignments', 'url' => 'teacher/assignments', 'icon' => 'fas fa-tasks'],
                    ['name' => 'Grades', 'url' => 'teacher/grades', 'icon' => 'fas fa-star']
                ];
                break;
                
            case 'student':
                $items['role_specific'] = [
                    ['name' => 'My Courses', 'url' => 'student/courses', 'icon' => 'fas fa-book-open'],
                    ['name' => 'Assignments', 'url' => 'student/assignments', 'icon' => 'fas fa-clipboard-list'],
                    ['name' => 'Grades', 'url' => 'student/grades', 'icon' => 'fas fa-graduation-cap'],
                    ['name' => 'Schedule', 'url' => 'student/schedule', 'icon' => 'fas fa-calendar-alt']
                ];
                break;
                
            default:
                $items['role_specific'] = [];
                break;
        }
        
        return $items;
    }

    /**
     * Refresh user session data from database
     */
    public function refresh_session()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        try {
            $userId = $this->session->get('userID');
            $builder = $this->db->table('users');
            $user = $builder->where('id', $userId)->get()->getRow();
            
            if ($user) {
                // Update session with fresh data from database
                $this->session->set([
                    'userID' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'isLoggedIn' => true
                ]);
                
                $this->session->setFlashdata('success', 'Session refreshed! Your role is now: ' . ucfirst($user->role));
            }
            
            return redirect()->to(base_url('dashboard'));
            
        } catch (\Exception $e) {
            $this->session->setFlashdata('error', 'Error refreshing session: ' . $e->getMessage());
            return redirect()->to(base_url('dashboard'));
        }
    }

    /**
     * Check database structure (temporary - remove in production)
     */
    public function check_db()
    {
        try {
            // Check table structure
            $query = $this->db->query("DESCRIBE users");
            $columns = $query->getResult();
            
            echo "<h3>Users Table Structure</h3>";
            echo "<table border='1' style='border-collapse: collapse; padding: 10px;'>";
            echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
            
            foreach ($columns as $column) {
                echo "<tr>";
                echo "<td>{$column->Field}</td>";
                echo "<td>{$column->Type}</td>";
                echo "<td>{$column->Null}</td>";
                echo "<td>{$column->Key}</td>";
                echo "<td>" . ($column->Default ?? 'NULL') . "</td>";
                echo "<td>{$column->Extra}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            echo "<br><h3>Fix Database</h3>";
            echo "<a href='" . base_url('auth/fix_database') . "' style='background: red; color: white; padding: 10px; text-decoration: none;'>Fix Role Column</a><br><br>";
            echo "<a href='" . base_url('auth/debug_roles') . "'>View User Roles</a>";
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Fix database role column (temporary - remove in production)
     */
    public function fix_database()
    {
        try {
            echo "<h3>Fixing Database...</h3>";
            
            // First, check current structure
            $query = $this->db->query("DESCRIBE users");
            $columns = $query->getResult();
            foreach ($columns as $column) {
                if ($column->Field === 'role') {
                    echo "<p>Current role column: {$column->Type} (Default: {$column->Default})</p>";
                }
            }
            
            // Update existing 'user' roles to 'student' first
            echo "<p>Updating existing 'user' roles to 'student'...</p>";
            $this->db->query("UPDATE users SET role = 'student' WHERE role = 'user'");
            
            // Alter the role column to support student, teacher, admin
            echo "<p>Modifying role column structure...</p>";
            $sql = "ALTER TABLE users MODIFY COLUMN role ENUM('student', 'teacher', 'admin') NOT NULL DEFAULT 'student'";
            $this->db->query($sql);
            
            // Verify the change
            $query = $this->db->query("DESCRIBE users");
            $columns = $query->getResult();
            foreach ($columns as $column) {
                if ($column->Field === 'role') {
                    echo "<p><strong>New role column: {$column->Type} (Default: {$column->Default})</strong></p>";
                }
            }
            
            echo "<h3>✅ Database Fixed Successfully!</h3>";
            echo "<p>Role column now supports: student, teacher, admin</p>";
            echo "<p>All existing 'user' roles have been changed to 'student'</p>";
            echo "<br><a href='" . base_url('auth/debug_roles') . "' style='background: blue; color: white; padding: 10px; text-decoration: none;'>View User Roles</a>";
            echo "<br><br><a href='" . base_url('dashboard') . "' style='background: green; color: white; padding: 10px; text-decoration: none;'>Go to Dashboard</a>";
            
        } catch (\Exception $e) {
            echo "<h3>❌ Error fixing database:</h3>";
            echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
            echo "<p>Please check your database connection and try again.</p>";
        }
    }

    /**
     * Debug method to check user roles (temporary - remove in production)
     */
    public function debug_roles()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        try {
            $builder = $this->db->table('users');
            $users = $builder->get()->getResult();
            
            echo "<h3>User Roles Debug</h3>";
            echo "<table border='1' style='border-collapse: collapse; padding: 10px;'>";
            echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Action</th></tr>";
            
            foreach ($users as $user) {
                $role = $user->role ?? 'NULL';
                echo "<tr>";
                echo "<td>{$user->id}</td>";
                echo "<td>{$user->name}</td>";
                echo "<td>{$user->email}</td>";
                echo "<td>{$role}</td>";
                echo "<td>";
                if (empty($user->role) || $user->role === 'user') {
                    echo "<a href='" . base_url("auth/fix_user_role/{$user->id}/student") . "'>Set as Student</a> | ";
                    echo "<a href='" . base_url("auth/fix_user_role/{$user->id}/teacher") . "'>Set as Teacher</a> | ";
                    echo "<a href='" . base_url("auth/fix_user_role/{$user->id}/admin") . "'>Set as Admin</a>";
                } else {
                    echo "Role OK";
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Fix user role (temporary - remove in production)
     */
    public function fix_user_role($userId, $role)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        $validRoles = ['student', 'teacher', 'admin'];
        if (!in_array($role, $validRoles)) {
            return redirect()->to(base_url('auth/debug_roles'))->with('error', 'Invalid role');
        }

        try {
            $builder = $this->db->table('users');
            $updated = $builder->where('id', $userId)->update(['role' => $role]);
            
            if ($updated) {
                // If updating current user, update session too
                if ($userId == $this->session->get('userID')) {
                    $this->session->set('role', $role);
                }
                return redirect()->to(base_url('auth/debug_roles'))->with('success', 'Role updated successfully');
            } else {
                return redirect()->to(base_url('auth/debug_roles'))->with('error', 'Failed to update role');
            }
        } catch (\Exception $e) {
            return redirect()->to(base_url('auth/debug_roles'))->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
