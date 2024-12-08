<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'emp_name'=>fake()->name(),
            'email'=>fake()->unique()->safeEmail(),
            'emp_address'=>fake()->secondaryAddress(),
            'emp_slug'=>'Emp-'.uniqId(),
            'emp_desig_id'=>rand(1,2),
            'emp_phone'=>fake()->phoneNumber(),
            'emp_role_id'=>1,
            'emp_creator'=>1,
            'emp_join'=>Carbon::now(),
            'password'=>Hash::make('111111'),
            'created_at'=>Carbon::now(),
        ];
    }
}
