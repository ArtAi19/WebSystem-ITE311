<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersTableRoles extends Migration
{
    public function up()
    {
        // Modify the role column to support student, teacher, admin
        $fields = [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['student', 'teacher', 'admin'],
                'default' => 'student',
            ],
        ];
        
        $this->forge->modifyColumn('users', $fields);
    }

    public function down()
    {
        // Revert back to original ENUM
        $fields = [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'user'],
                'default' => 'user',
            ],
        ];
        
        $this->forge->modifyColumn('users', $fields);
    }
}
