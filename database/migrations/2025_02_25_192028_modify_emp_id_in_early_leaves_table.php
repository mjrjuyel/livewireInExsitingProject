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
        Schema::table('early_leaves', function (Blueprint $table) {
            // Add the new foreign key column
            $table->dropForeign(['leave_type']);
            $table->foreignId('leave_type')->constrained('leave_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('early_leaves', function (Blueprint $table) {
            //
        });
    }
};
