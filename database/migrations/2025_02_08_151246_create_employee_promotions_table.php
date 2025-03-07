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
        if (!Schema::hasTable('employee_promotions')) {

        Schema::create('employee_promotions', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('emp_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->foreignId('emp_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('depart_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('desig_id')->nullable()->constrained('designations')->onDelete('set null');
            $table->string('pro_status',20)->default('Unchanged')->nullable();
            $table->string('emp_type',20)->nullable();
            $table->decimal('salary','10',2)->nullable();
            $table->foreignId('promoted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('pro_date')->nullable();
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_promotions');
    }
};
