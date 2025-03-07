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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('submit_by')->references('id')->on('employees')->onDelete('cascade');
            $table->foreignId('submit_by')->references('id')->on('users')->onDelete('cascade');
            $table->date('submit_date')->nullable();
            $table->text('detail')->nullable();
            $table->string('check_in',50)->nullable();
            $table->string('check_out',50)->nullable();
            $table->string('slug',25)->nullable();
            $table->integer('status')->default(1);
            $table->integer('editor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
