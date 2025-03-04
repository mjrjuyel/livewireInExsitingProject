<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeLeaveSetting;
use Carbon\Carbon;

class EmployeLeaveSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeLeaveSetting::create([
            'year_limit' => 14,
            'month_limit' => 3,
            'weekoffday'=>5,
            'specialoffday'=>'2024-12-16, 2024-12-20, 2024-12-25, 2024-12-26, 2024-12-27',
            'created_at' => Carbon::now(),
        ]);
    }
}
