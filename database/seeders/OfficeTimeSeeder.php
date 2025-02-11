<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OfficeTime;
use Carbon\Carbon;
class OfficeTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OfficeTime::create([
            'office_start' => Carbon::parse('11:00', config('app.timezone'))->setTimezone('UTC')->format('H:i'),
            'office_end' => Carbon::parse('19:30', config('app.timezone'))->setTimezone('UTC')->format('H:i'),
            'created_at' => Carbon::now('UTC')
        ]);
    }
}
