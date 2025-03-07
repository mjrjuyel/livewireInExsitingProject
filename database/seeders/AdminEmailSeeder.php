<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminEmail;
use Carbon\Carbon;

class AdminEmailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminEmail::create([
            'email'=>'mjrcoder7@gmail.com',
            'creator'=>1,
            'created_at'=>Carbon::now(),
        ]);
    }
}
