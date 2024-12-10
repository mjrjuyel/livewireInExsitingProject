<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeaveType;
use Carbon\Carbon;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeaveType::create([
            'type_title'=>'Fever',
            'created_at'=>Carbon::now(),
        ]);
    }
}
