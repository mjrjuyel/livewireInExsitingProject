<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'SupreoX',
            'email'=>'admin@gmail.com',
            'slug'=>'user-'.uniqId(),
            'role_id'=>1,
            'password'=>Hash::make('11111111'),
            'created_at'=>Carbon::now(),
        ]);

    }
}
