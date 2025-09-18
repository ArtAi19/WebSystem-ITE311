<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin user
            [
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'email'      => 'admin@lms.com',
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Instructors
            [
                'username'   => 'instructor1',
                'password'   => password_hash('instructor123', PASSWORD_DEFAULT),
                'email'      => 'instructor1@lms.com',
                'role'       => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username'   => 'instructor2',
                'password'   => password_hash('instructor123', PASSWORD_DEFAULT),
                'email'      => 'instructor2@lms.com',
                'role'       => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            // Students
            [
                'username'   => 'student1',
                'password'   => password_hash('student123', PASSWORD_DEFAULT),
                'email'      => 'student1@lms.com',
                'role'       => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username'   => 'student2',
                'password'   => password_hash('student123', PASSWORD_DEFAULT),
                'email'      => 'student2@lms.com',
                'role'       => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'username'   => 'student3',
                'password'   => password_hash('student123', PASSWORD_DEFAULT),
                'email'      => 'student3@lms.com',
                'role'       => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Using Query Builder
        $this->db->table('users')->insertBatch($data);
    }
}
