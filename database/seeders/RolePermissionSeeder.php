<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
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

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `created_at`, `updated_at`) VALUES
                            -- Employee Dashboard
                            ('Employee', 'web', '2025-02-03 05:35:32', '2025-02-03 05:35:32'),
                            -- Application Dashboard
                            ('Application Dashboard', 'web', '2025-02-03 05:35:32', '2025-02-03 05:35:32'),
                            -- User and Role
                            ('User & Role', 'web', '2025-02-03 05:36:03', '2025-02-03 05:36:15'),
                            ('All User', 'web', '2025-02-03 05:36:32', '2025-02-03 05:36:32'),
                            ('Add User', 'web', '2025-02-03 05:36:56', '2025-02-03 05:36:56'),
                            ('View User', 'web', '2025-02-03 05:37:29', '2025-02-03 05:37:29'),
                            ('Edit User', 'web', '2025-02-03 05:37:37', '2025-02-03 05:37:37'),
                            ('Delete User', 'web', '2025-02-03 05:37:45', '2025-02-03 05:37:45'),
                            ('Soft Delete User', 'web', '2025-02-03 05:37:45', '2025-02-03 05:37:45'),
                            ('Restore User', 'web', '2025-02-03 05:37:45', '2025-02-03 05:37:45'),
                            ('Login Another Profile', 'web', '2025-02-03 05:37:45', '2025-02-03 05:37:45'),
                            -- Role Handle
                            ('All Role', 'web', '2025-02-03 05:38:32', '2025-02-03 05:38:32'),
                            ('Add Role', 'web', '2025-02-03 05:38:40', '2025-02-03 05:38:40'),
                            ('View Role', 'web', '2025-02-03 05:38:48', '2025-02-03 05:38:48'),
                            ('Edit Role', 'web', '2025-02-03 05:38:56', '2025-02-03 05:38:56'),
                            ('Delete Role', 'web', '2025-02-03 05:39:13', '2025-02-03 05:39:13'),
                            -- Permission
                            ('All Permission', 'web', '2025-02-03 05:39:27', '2025-02-03 05:39:27'),
                            ('Add Permission', 'web', '2025-02-03 05:39:42', '2025-02-03 05:39:42'),
                            ('View Permission', 'web', '2025-02-03 05:39:52', '2025-02-03 05:39:52'),
                            ('Edit Permission', 'web', '2025-02-03 05:39:59', '2025-02-03 05:39:59'),
                            ('Delete Permission', 'web', '2025-02-03 05:40:05', '2025-02-03 05:40:05'),
                            -- Leave Handle
                            ('Leave', 'web', '2025-02-03 05:44:31', '2025-02-03 05:44:31'),
                            ('Leave Application List', 'web', '2025-02-03 05:45:21', '2025-02-03 05:45:21'),
                            ('View Leave', 'web', '2025-02-03 05:46:25', '2025-02-03 05:46:25'),
                            ('Edit Leave', 'web', '2025-02-03 05:46:32', '2025-02-03 05:46:32'),
                            ('Delete Leave', 'web', '2025-02-03 05:46:38', '2025-02-03 05:46:38'),
                            -- Leave Manually
                            ('Add Manual Leave', 'web', '2025-02-03 05:46:09', '2025-02-03 05:46:09'),
                            ('Edit Manual Leave', 'web', '2025-02-03 05:46:09', '2025-02-03 05:46:09'),
                            -- Early leave
                            ('All Early Leave', 'web', '2025-02-03 05:44:31', '2025-02-03 05:44:31'),
                            ('Add Early Leave', 'web', '2025-02-03 05:44:31', '2025-02-03 05:44:31'),
                            ('Edit Early Leave', 'web', '2025-02-03 05:44:31', '2025-02-03 05:44:31'),
                            ('View Early Leave', 'web', '2025-02-03 05:44:31', '2025-02-03 05:44:31'),
                            ('Delete Early Leave', 'web', '2025-02-03 05:44:31', '2025-02-03 05:44:31'),
                             -- Leave Type
                            ('Leave Type', 'web', '2025-02-03 05:46:56', '2025-02-03 05:46:56'),
                            ('Leave Type Add', 'web', '2025-02-03 05:47:07', '2025-02-03 05:47:07'),
                            ('Leave Type View', 'web', '2025-02-03 05:47:19', '2025-02-03 05:47:19'),
                            ('Leave Type Edit', 'web', '2025-02-03 05:47:30', '2025-02-03 05:47:30'),
                            ('Leave Type Delete', 'web', '2025-02-03 05:47:37', '2025-02-03 05:47:37'),
                            -- Daily Report
                            ('Daily-Report', 'web', '2025-02-03 05:48:48', '2025-02-03 06:34:22'),
                            ('View Daily-Report', 'web', '2025-02-03 05:49:00', '2025-02-03 05:49:00'),
                            ('Edit Daily-Report', 'web', '2025-02-03 05:49:16', '2025-02-03 05:49:16'),
                            ('Soft Delete Daily-Report', 'web', '2025-02-03 05:50:42', '2025-02-03 05:50:42'),
                            ('Restore Daily-Report', 'web', '2025-02-03 05:51:24', '2025-02-03 05:51:24'),
                            ('Delete Daily-Report', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            -- Evalution
                            ('All Employee Evaluation', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('Add Employee Evaluation', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('Edit Employee Evaluation', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('View Employee Evaluation', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('Delete Employee Evaluation', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            -- employee Promtoion
                            ('All Employee Promotion', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('Add Employee Promotion', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('Edit Employee Promotion', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('View Employee Promotion', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            ('Delete Employee Promotion', 'web', '2025-02-03 05:51:56', '2025-02-03 05:51:56'),
                            -- Depart ment And Designation
                            ('Department & Designation', 'web', '2025-02-03 06:09:55', '2025-02-03 06:11:35'),
                            ('Departments', 'web', '2025-02-03 06:13:05', '2025-02-03 06:13:05'),
                            ('Add Department', 'web', '2025-02-03 06:13:21', '2025-02-03 06:13:21'),
                            ('View Department', 'web', '2025-02-03 06:13:49', '2025-02-03 06:13:49'),
                            ('Edit Department', 'web', '2025-02-03 06:13:56', '2025-02-03 06:13:56'),
                            ('Delete Department', 'web', '2025-02-03 06:14:01', '2025-02-03 06:14:01'),
                            ('Designation', 'web', '2025-02-03 06:14:07', '2025-02-03 06:14:07'),
                            ('Add Designation', 'web', '2025-02-03 06:14:14', '2025-02-03 06:14:14'),
                            ('View Designation', 'web', '2025-02-03 06:14:26', '2025-02-03 06:14:26'),
                            ('Edit Designation', 'web', '2025-02-03 06:14:40', '2025-02-03 06:14:40'),
                            ('Delete Designation', 'web', '2025-02-03 06:14:52', '2025-02-03 06:14:52'),
                            -- 0fFice branch
                            ('Office Branch', 'web', '2025-02-03 06:15:34', '2025-02-03 07:01:56'),
                            ('Add Office Branch', 'web', '2025-02-03 06:15:52', '2025-02-03 06:15:52'),
                            ('View Office Branch', 'web', '2025-02-03 06:16:56', '2025-02-03 06:16:56'),
                            ('Edit Office Branch', 'web', '2025-02-03 06:17:05', '2025-02-03 06:17:05'),
                            ('Delete Office Branch', 'web', '2025-02-03 06:17:34', '2025-02-03 06:17:34'),
                            -- Bank And Barnch
                            ('Bank & Branch', 'web', '2025-02-03 06:17:58', '2025-02-03 07:31:20'),
                            ('Bank Detail', 'web', '2025-02-03 06:18:22', '2025-02-03 06:18:22'),
                            ('Add Bank Detail', 'web', '2025-02-03 06:18:35', '2025-02-03 06:18:35'),
                            ('View Bank Detail', 'web', '2025-02-03 06:18:46', '2025-02-03 06:18:46'),
                            ('Edit Bank Detail', 'web', '2025-02-03 06:18:53', '2025-02-03 06:18:53'),
                            ('Delete Bank Detail', 'web', '2025-02-03 06:19:09', '2025-02-03 06:19:09'),
                            ('Bank Branch', 'web', '2025-02-03 06:19:30', '2025-02-03 08:23:46'),
                            ('Add Bank Branch', 'web', '2025-02-03 06:19:56', '2025-02-03 06:19:56'),
                            ('View Bank Branch', 'web', '2025-02-03 06:20:03', '2025-02-03 06:20:03'),
                            ('Edit Bank Branch', 'web', '2025-02-03 06:20:16', '2025-02-03 06:20:16'),
                            ('Delete Bank Branch', 'web', '2025-02-03 06:21:08', '2025-02-03 06:21:08'),
                            -- Catering Section
                            ('Catering', 'web', '2025-02-03 06:21:45', '2025-02-03 06:21:45'),
                            ('Add Meal', 'web', '2025-02-03 06:22:41', '2025-02-03 06:22:41'),
                            ('View Meal', 'web', '2025-02-03 06:23:33', '2025-02-03 06:23:33'),
                            ('Edit Meal', 'web', '2025-02-03 06:23:39', '2025-02-03 06:23:39'),
                            ('Delete Meal', 'web', '2025-02-03 06:23:44', '2025-02-03 06:23:44'),
                            ('Add Payment', 'web', '2025-02-03 06:23:58', '2025-02-03 06:23:58'),
                            ('Edit Payment', 'web', '2025-02-03 06:24:14', '2025-02-03 06:24:14'),
                            ('View Payment', 'web', '2025-02-03 06:24:20', '2025-02-03 06:24:20'),
                            ('Delete Payment', 'web', '2025-02-03 06:24:32', '2025-02-03 06:24:32'),
                            ('Check Balance', 'web', '2025-02-03 06:24:44', '2025-02-03 06:24:44'),
                            -- Seetings 
                            ('Setting', 'web', '2025-02-03 06:25:07', '2025-02-03 06:25:07'),
                            -- recycle bin
                            ('Recycle Bin', 'web', '2025-02-03 06:25:28', '2025-02-03 06:25:28');
                        ");

        DB::table('role_has_permissions')->truncate();
        // Assign all permissions to Super Admin
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $superAdminRole->syncPermissions(Permission::all());

        // Assign Super Admin role to the first user
        DB::table('model_has_roles')->truncate();
        $users = User::all();
        foreach($users as $user) {
            $user->assignRole('Super Admin');
        }
    }
}
