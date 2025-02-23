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
    if (!Schema::hasTable('admin_emails')) {
        Schema::create('admin_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->integer('email_report')->default(1)->nullable();
            $table->integer('email_leave')->default(1)->nullable();
            $table->integer('email_summary')->default(1)->nullable();
            $table->integer('creator')->nullable();
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
        Schema::dropIfExists('admin_emails');
    }
};
