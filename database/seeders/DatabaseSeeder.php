<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Run Role Permission Seeder
        $this->call(RolePermissionSeeder::class);

        // Create Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'mobile' => '1234567890',
            'password' => Hash::make('admin123'),
            'role_id' => '1', // Role ID if stored in DB
            'status' => '2', // Role ID if stored in DB
        ]);
        $admin->assignRole('admin'); // Assign Admin Role

        $superAdmin = User::create([
            'name' => 'Super Admin User',
            'email' => 'superadmin@example.com',
            'mobile' => '9876543210',
            'password' => Hash::make('superadmin123'),
            'role_id' => '2', // Role ID if stored in DB
            'status' => '2', // Role ID if stored in DB
        ]);
        $superAdmin->assignRole('super-admin'); // Assign Super Admin Role

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'mobile' => '1112223333',
            'password' => Hash::make('user123'),
            'role_id' => '3',
        ]);
        $user->assignRole('student'); // Assign User Role
    }
}
