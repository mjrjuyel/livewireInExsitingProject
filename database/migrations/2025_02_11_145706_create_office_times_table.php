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
        if (!Schema::hasTable('office_times')) {

        Schema::create('office_times', function (Blueprint $table) {
            $table->id();
            $table->string('office_start')->nullable();
            $table->string('office_end')->nullable();
            $table->integer('editor')->nullable();
            $table->timestamps();
        });

    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_times');
    }
};
