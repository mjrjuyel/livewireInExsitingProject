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
        // Schema::create('employees', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('emp_name',100)->nullable();
        //     $table->string('email',40)->nullable();
        //     $table->string('email2',40)->nullable();
        //     $table->string('emp_phone',20)->nullable();
        //     $table->string('emp_phone2',20)->nullable();
        //     $table->string('emp_address',100)->nullable();
        //     $table->string('emp_present',100)->nullable();
        //     $table->string('emp_emer_contact',20)->nullable();
        //     $table->string('emp_emer_name',50)->nullable();
        //     $table->string('emp_emer_relation',100)->nullable();
        //     $table->date('emp_dob',100)->nullable();
        //     $table->string('gender',20)->nullable();
        //     $table->string('marriage',20)->nullable();
        //     $table->string('emp_image',100)->nullable();
        //     $table->integer('emp_status')->default(1);
        //     $table->string('emp_slug',24)->nullable();
        //     // job detail
        //     $table->integer('emp_report_manager')->nullable();
        //     $table->integer('emp_depart_id')->nullable();
        //     $table->integer('emp_desig_id')->nullable();
        //     $table->integer('emp_role_id')->nullable();
        //     $table->string('emp_type')->nullable();
        //     $table->date('emp_join',100)->nullable();
        //     $table->date('emp_resign',100)->nullable();
            
        //     // evaluation
        //     $table->date('eva_start_date',100)->nullable();
        //     $table->date('eva_end_date',100)->nullable();
        //     // identi verification
        //     $table->string('emp_id_type')->nullable();
        //     $table->string('emp_id_number')->nullable();

        //     // education qualification
        //     $table->string('emp_rec_degree')->nullable();
        //     $table->string('emp_rec_year')->nullable();

        //     // bank statement
        //     $table->integer('emp_bank_id')->nullable();
        //     $table->integer('emp_bank_branch_id')->nullable();
        //     $table->string('emp_bank_account_name')->nullable();
        //     $table->string('emp_bank_account_number',50)->nullable();
        //     $table->string('emp_bank_swift_code')->nullable();
        //     $table->string('emp_bank_sort_code')->nullable();
        //     $table->string('emp_bank_routing_number')->nullable();
        //     $table->string('emp_bank_country')->nullable();
        //     // company Specific field
        
        //     // Office 
        //     $table->integer('emp_office_branch_id')->nullable();
        //     $table->string('emp_office_id_number')->nullable();
        //     $table->string('emp_office_card_number')->nullable();
        //     $table->string('emp_office_IT_requirement')->nullable();
        //     $table->string('emp_office_work_schedule')->nullable();

        //     // $table->integer('emp_aggrement')->nullable();
        //     $table->string('emp_signature')->nullable();

        //     $table->integer('emp_creator');
        //     $table->integer('emp_editor')->nullable();
        //     $table->string('password');
        //     $table->string('remember_token')->nullable();
        //     $table->string('device_token')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
