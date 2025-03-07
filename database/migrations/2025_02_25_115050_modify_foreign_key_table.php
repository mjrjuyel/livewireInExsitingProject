<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('daily_reports', function (Blueprint $table) {
        //    // Drop the existing foreign key constraint
        //     $table->dropForeign(['submit_by']);
        //     // Add new foreign key with a unique name
        //     $table->foreign('submit_by', 'fk_daily_reports_submit_by')->references('id')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
