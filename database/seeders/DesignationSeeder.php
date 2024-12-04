<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Designation;
use Carbon\Carbon;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Designation::create([
            'title'=>'Laravel Web Developer',
            'created_at'=>Carbon::now(),
        ]);
    }
}
