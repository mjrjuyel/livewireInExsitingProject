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
            'email'=>'bashar@supreoxmail.com',
            'slug'=>'user-'.uniqId(),
            'role_id'=>1,
            'password'=>Hash::make('super%%@admin'),
            'created_at'=>Carbon::now(),
        ]);

    }
}
