<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Super Admin'
        ];
        // Create roles
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Assign all permissions to Super Admin
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $superAdminRole->syncPermissions(Permission::all());

        // Assign Super Admin role to the first user
        $users = User::all();
        foreach($users as $user) {
            $user->assignRole('Super Admin');
        }
    }
}
