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
            $table->integer('leave_type_id')->nullable;
            $table->text('reason')->nullable();
            $table->integer('status')->default('1');
            $table->string('slug')->nullable();
            $table->integer('total_paid')->nullable();
            $table->integer('total_leave_this_month')->nullable();
            // unpaid
            $table->integer('unpaid_request')->nullable();
            $table->integer('total_unpaid')->nullable();
            // Foreign key constraint
            $table->integer('emp_id')->nullable();
            $table->string('comments')->nullable();
            $table->integer('editor')->nullable();
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
