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
        if (!Schema::hasTable('early_leaves')) {

        Schema::create('early_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('start')->nullable();
            $table->string('end')->nullable();
            $table->date('leave_date')->nullable();
            $table->foreignId('leave_type')->constrained('leave_types')->onDelete('cascade');
            $table->string('other_type',50)->nullable();
            $table->text('detail')->nullable();
            $table->integer('status')->default('1');
            $table->string('total_hour')->nullable();
            $table->string('leave_summary')->nullable();
            // unpaid
            $table->integer('unpaid_request')->nullable();
            $table->string('submit_by',50)->nullable();
            // Foreign key constraint
            $table->foreignId('emp_id')->constrained('employees')->onDelete('cascade');
            $table->string('comments')->nullable();
            $table->foreignId('editor')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('early_leaves');
    }
};
