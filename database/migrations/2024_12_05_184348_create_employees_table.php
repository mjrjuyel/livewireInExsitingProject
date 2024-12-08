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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_name',100)->nullable();
            $table->string('email',100)->nullable();
            $table->string('emp_phone',100)->nullable();
            $table->string('emp_address',100)->nullable();
            $table->string('emp_image',100)->nullable();
            $table->integer('emp_status')->default(1);
            $table->string('emp_slug',24)->nullable();
            $table->integer('emp_desig_id')->nullable();
            $table->integer('emp_role_id')->nullable();
            $table->date('emp_join',100)->nullable();
            $table->integer('emp_can_leave')->default(20);
            $table->integer('emp_creator');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
