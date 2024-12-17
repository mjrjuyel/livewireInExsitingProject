<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Basic;
use Carbon\Carbon;

class BasicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Basic::create([
            'copyright'=>date('Y').'E-TeamfY - By SupereoX',
            'created_at'=>Carbon::now(),
        ]);
    }
}
