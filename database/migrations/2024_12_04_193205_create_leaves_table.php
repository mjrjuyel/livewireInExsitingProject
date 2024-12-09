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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('leave_type')->nullable;
            $table->text('reason')->nullable();
            $table->integer('status')->default('1');
            $table->string('slug')->nullable();
            $table->integer('total_day')->nullable();
            $table->integer('paid_remainig_month')->nullable();
            $table->integer('paid_remaining_year')->nullable();
            // Foreign key constraint
            $table->integer('emp_id')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
