<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TimeZone;
use Carbon\Carbon;

class TimeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimeZone::create([
            'name' => 'Asia/Dhaka',
            'created_at'=>Carbon::now(),
        ]);
    }
}
