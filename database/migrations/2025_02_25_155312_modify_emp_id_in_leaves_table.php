<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            // Rename the column to temporarily store existing data
            $table->renameColumn('emp_id', 'temp_emp_id');
        });

        Schema::table('leaves', function (Blueprint $table) {
            // Add the new foreign key column
            $table->foreignId('emp_id')->nullable()->constrained('users')->onDelete('cascade')->after('add_from');
        });
        // Copy existing data back, ensuring NULL values are handled safely
        DB::statement('UPDATE leaves SET emp_id = temp_emp_id WHERE temp_emp_id IS NOT NULL');

        Schema::table('leaves', function (Blueprint $table) {
            // Drop the temporary column
            $table->dropColumn('temp_emp_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            //
        });
    }
};
