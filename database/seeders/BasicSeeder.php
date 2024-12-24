<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File; // For file operations
use App\Models\Basic;
use Carbon\Carbon;

class BasicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $sourcePath = public_path('uploads/basic/seed/mlogo.png');

        if (!File::exists($sourcePath)) {
            $this->command->error('Source file not found: ' . $sourcePath);
            return;
        }

        $destinationPath = public_path('uploads/basic/mlogo.png');

        // Copy the file to the destination
        File::copy($sourcePath, $destinationPath);

        // Verify the file was copied
        if (File::exists($destinationPath)) {
            // Save the path to the database
            Basic::create([
                'copyright'=>'E-TeamifY - By SupreoX',
                'Mlogo'=>'mlogo.png',
                'created_at'=>Carbon::now(),
            ]);

            $this->command->info('Image copied from uploads/basic/seed/mlogo.png to uploads/basic/mlogo.png and path stored in database.');
        } else {
            $this->command->error('Failed to copy the image.');
        }

        
    }
}
