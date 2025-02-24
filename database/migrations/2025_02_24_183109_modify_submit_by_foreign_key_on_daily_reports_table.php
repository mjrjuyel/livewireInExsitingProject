<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            DB::statement('ALTER TABLE daily_reports DROP FOREIGN KEY daily_reports_submit_by_foreign');


            // Update the foreign key constraint to reference the 'users' table
            $table->foreignId('submit_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('daily_reports', function (Blueprint $table) {
            // Rollback the foreign key constraint to reference 'employees' in case of migration rollback
            $table->dropForeign(['submit_by']);
            $table->foreign('submit_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }
};
