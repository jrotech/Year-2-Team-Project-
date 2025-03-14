<?php
/********************************
Developer: [Your Name]
University ID: [Your ID]
 ********************************/
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin role if it doesn't exist
        $adminRole = Role::firstOrCreate(
            ['name' => 'Administrator'],
            ['name' => 'Administrator']
        );

        // Create staff role if it doesn't exist
        $staffRole = Role::firstOrCreate(
            ['name' => 'Staff'],
            ['name' => 'Staff']
        );

        // Create role permissions for admin
        $tables = ['products', 'categories', 'customers', 'invoices', 'users', 'roles'];

        foreach ($tables as $table) {
            RolePermission::firstOrCreate(
                [
                    'role_id' => $adminRole->id,
                    'table_name' => $table
                ],
                [
                    'role_id' => $adminRole->id,
                    'table_name' => $table,
                    'read' => true,
                    'write' => true,
                    'delete' => true
                ]
            );

            // Create limited permissions for staff
            RolePermission::firstOrCreate(
                [
                    'role_id' => $staffRole->id,
                    'table_name' => $table
                ],
                [
                    'role_id' => $staffRole->id,
                    'table_name' => $table,
                    'read' => true,
                    'write' => $table !== 'users' && $table !== 'roles',
                    'delete' => false
                ]
            );
        }

        // Create admin user if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id
            ]
        );
    }
}
