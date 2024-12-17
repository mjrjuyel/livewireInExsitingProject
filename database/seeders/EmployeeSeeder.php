<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'emp_name'=>'Test',
            'email'=>'test@gmail.com',
            'emp_address'=>'Dhaka-1230',
            'emp_slug'=>'Emp-'.uniqId(),
            'emp_desig_id'=>rand(1,2),
            'emp_phone'=>'01754172525',
            'emp_role_id'=>1,
            'emp_creator'=>1,
            'emp_join'=>Carbon::now(),
            'password'=>Hash::make('employe%%@'),
            'created_at'=>Carbon::now(),
        ]);
    }
}
