<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // UserRoleSeeder::class,
            DesignationSeeder::class,
            // EmployeeSeeder::class,
            LeaveTypeSeeder::class,  
            EmployeLeaveSettingSeeder::class,
            BasicSeeder::class,
            TimeZoneSeeder::class,
            AdminEmailSeeder::class,
            RolePermissionSeeder::class,
            CurrencySeeder::class,
            OfficeTimeSeeder::class,
        ]);

            // User::factory(10)->create();
        // \App\Models\Employee::factory(5)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
