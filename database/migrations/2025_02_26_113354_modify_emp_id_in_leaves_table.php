<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('leaves', function (Blueprint $table) {
        //     // Rename the column to temporarily store existing data
        //     $table->renameColumn('emp_id', 'temp_emp_id');
        // });
        // Schema::table('leaves', function (Blueprint $table) {
        //     $table->foreignId('emp_id')->nullable()->constrained('users')->onDelete('cascade')->after('add_from');
        // });
        // DB::statement('UPDATE leaves SET emp_id = temp_emp_id WHERE temp_emp_id IS NOT NULL');

        // Schema::table('leaves', function (Blueprint $table) {
        //     $table->dropColumn('temp_emp_id');
        // });

        // // early leaves chnages
      
        // Schema::table('early_leaves', function (Blueprint $table) {
        //     $table->dropForeign(['leave_type']);
        //     // Modify the column to allow NULL values
        //     $table->unsignedBigInteger('leave_type')->nullable()->change();
        //     // Re-add the foreign key with onDelete('set null')
        //     $table->foreign('leave_type')->references('id')->on('leave_types')->nullOnDelete();
        // });

        // Schema::table('early_leaves', function (Blueprint $table) {
        //      $table->dropForeign(['emp_id']);
        //      $table->foreign('emp_id', 'fk_early_leaves_emp_id')->references('id')->on('users')->onDelete('cascade');
        //  });

        // //  Employee promotion Foreign Key
        // Schema::table('employee_promotions', function (Blueprint $table) {
        //      $table->dropForeign(['emp_id']);
        //      $table->foreign('emp_id', 'fk_employee_promotions_emp_id')->references('id')->on('users')->onDelete('cascade');
        //  });

        // //  Employee Evalution Foreign key
        // Schema::table('employee_evaluations', function (Blueprint $table) {
        //      $table->dropForeign(['emp_id']);
        //      $table->foreign('emp_id', 'fk_employee_evaluations_emp_id')->references('id')->on('users')->onDelete('cascade');
        //  });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            //
        });
    }
};
