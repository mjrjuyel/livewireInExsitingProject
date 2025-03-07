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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_title',50)->nullable();
            $table->timestamps();
        });

        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('leave_type_id')->nullable()->constrained('leave_types')->onDelete('set null');
            $table->string('other_type',50)->nullable;
            $table->text('reason')->nullable();
            $table->integer('status')->default('1');
            $table->string('slug')->nullable();
            $table->integer('total_paid')->nullable();
            $table->integer('total_leave_this_month')->nullable();
            // unpaid
            $table->integer('unpaid_request')->nullable();
            $table->integer('total_unpaid')->nullable();
            $table->string('add_from',50)->nullable();
            // Foreign key constraint
            // $table->integer('emp_id')->nullable();
            $table->foreignId('emp_id')->nullable()->constrained('users')->onDelete('cascade');
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
