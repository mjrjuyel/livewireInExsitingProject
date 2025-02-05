<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use Carbon\Carbon;
class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Currency::create([
            'currency_icon'=>'৳',
            'editor'=>1,
            'created_at'=>Carbon::now('UTC'),
        ]);
    }
}
