<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $managerRole = Role::where('name', 'inventory_manager')->first();
        $auditorRole = Role::where('name', 'auditor')->first();

        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@grocery.com',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'role_id' => $adminRole->id,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['username' => 'manager'],
            [
                'name' => 'Inventory Manager',
                'email' => 'manager@grocery.com',
                'username' => 'manager',
                'password' => Hash::make('manager123'),
                'role_id' => $managerRole->id,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['username' => 'auditor'],
            [
                'name' => 'System Auditor',
                'email' => 'auditor@grocery.com',
                'username' => 'auditor',
                'password' => Hash::make('auditor123'),
                'role_id' => $auditorRole->id,
                'is_active' => true,
            ]
        );
    }
}
