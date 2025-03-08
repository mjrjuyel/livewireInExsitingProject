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
        if (!Schema::hasTable('catering_payments')) {

        Schema::create('catering_payments', function (Blueprint $table) {
            $table->id();
            $table->date('payment_date')->nullable();
            $table->decimal('payment',10,2)->nullable();
            $table->decimal('total_payment',10,2)->nullable();
            $table->integer('p_creator')->nullable();
            $table->integer('p_editor')->nullable();
            $table->timestamps();
        });
    }
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catering_payments');
    }
};
