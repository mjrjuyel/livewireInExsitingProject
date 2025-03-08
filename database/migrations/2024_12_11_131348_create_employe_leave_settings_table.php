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
        Schema::create('employe_leave_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('year_limit')->nullable();
            $table->integer('month_limit')->nullable();
            $table->integer('weekoffday')->nullable();
            $table->text('specialoffday')->nullable();
            $table->integer('editor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employe_leave_settings');
    }
};
