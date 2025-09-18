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
                'password' => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]'
            ]);

            // If validation passes, hash the password using password_hash()
            if ($validation->withRequest($this->request)->run()) {
                $name = $this->request->getPost('name');
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Save the user data (name, email, hashed_password, role) to the users table
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => $hashedPassword,
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $builder = $this->db->table('users');
                
                try {
                    if ($builder->insert($data)) {
                        // On success, set a flash message and redirect to the login page
                        $this->session->setFlashdata('success', 'Account registered successfully! Please login.');
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
     */
    public function dashboard()
    {
        // Check if a user is logged in at the start of the method. If not, redirect them to the login page
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login to access the dashboard.');
        }

        $data = [
            'user' => [
                'name' => $this->session->get('name'),
                'email' => $this->session->get('email'),
                'role' => $this->session->get('role')
            ]
        ];

        return view('auth/dashboard', $data);
    }
}
