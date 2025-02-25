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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            
            $table->integer('role_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->string('slug')->nullable();

            // $table->string('email2')->nullable();
           
            // $table->string('phone', 20)->nullable();
            // $table->string('phone2', 20)->nullable();
            // $table->string('address', 100)->nullable();
            // $table->string('present', 100)->nullable();
            // $table->string('emer_contact', 20)->nullable();
            // $table->string('emer_name', 50)->nullable();
            // $table->string('emer_relation', 100)->nullable();
            // $table->date('dob')->nullable();
            // $table->string('gender', 20)->nullable();
            // $table->string('marriage', 20)->nullable();
            // // Job Details
            // $table->integer('report_manager')->nullable();
            // $table->integer('depart_id')->nullable();
            // $table->integer('desig_id')->nullable();
            // $table->string('email')->nullable()->change();
            // $table->string('emp_type')->nullable();
            // $table->date('join_date')->nullable();
            // $table->date('resign_date')->nullable();

            // // Evaluation
            // $table->date('eva_start_date')->nullable();
            // $table->date('eva_end_date')->nullable();

            // // Identity Verification
            // $table->string('id_type')->nullable();
            // $table->string('id_number')->nullable();

            // // Education
            // $table->string('rec_degree')->nullable();
            // $table->string('rec_year')->nullable();

            // // Bank Details
            // $table->integer('bank_id')->nullable();
            // $table->integer('bank_branch_id')->nullable();
            // $table->string('bank_account_name')->nullable();
            // $table->string('bank_account_number', 50)->nullable();
            // $table->string('bank_swift_code')->nullable();
            // $table->string('bank_sort_code')->nullable();
            // $table->string('bank_routing_number')->nullable();
            // $table->string('bank_country')->nullable();

            // // Office Details
            // $table->integer('office_branch_id')->nullable();
            // $table->string('office_id_number')->nullable();
            // $table->string('office_card_number')->nullable();
            // $table->string('office_IT_requirement')->nullable();
            // $table->string('office_work_schedule')->nullable();

            // // Other Fields
            // $table->string('signature')->nullable();
            // $table->integer('creator')->nullable();
            // $table->integer('editor')->nullable();
            // $table->string('device_token')->nullable();

            // // from Employee

            $table->string('image')->nullable();

            $table->integer('status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }

//     Schema::create('users', function (Blueprint $table) {
//         $table->id();
//         $table->string('name',100)->nullable();
//         $table->string('email',40)->nullable();
//         $table->string('email2',40)->nullable();
//         $table->string('phone',20)->nullable();
//         $table->string('phone2',20)->nullable();
//         $table->string('address',100)->nullable();
//         $table->string('present',100)->nullable();
//         $table->string('emer_contact',20)->nullable();
//         $table->string('emer_name',50)->nullable();
//         $table->string('emer_relation',100)->nullable();
//         $table->date('dob',100)->nullable();
//         $table->string('gender',20)->nullable();
//         $table->string('marriage',20)->nullable();
//         $table->string('image',100)->nullable();
//         $table->string('slug',24)->nullable();
//         // job detail
//         $table->integer('report_manager')->nullable();
//         $table->integer('depart_id')->nullable();
//         $table->integer('desig_id')->nullable();
//         $table->string('type')->nullable();
//         $table->date('join',100)->nullable();
//         $table->date('resign',100)->nullable();
        
//         // evaluation
//         $table->date('eva_start_date',100)->nullable();
//         $table->date('eva_start_end',100)->nullable();
//         // identi verification
//         $table->string('id_type')->nullable();
//         $table->string('id_number')->nullable();

//         // education qualification
//         $table->string('rec_degree')->nullable();
//         $table->string('rec_year')->nullable();

//         // bank statement
//         $table->integer('bank_id')->nullable();
//         $table->integer('bank_branch_id')->nullable();
//         $table->string('bank_account_name')->nullable();
//         $table->string('bank_account_number',50)->nullable();
//         $table->string('bank_swift_code')->nullable();
//         $table->string('bank_sort_code')->nullable();
//         $table->string('bank_routing_number')->nullable();
//         $table->string('bank_country')->nullable();
    
//         // Office 
//         $table->integer('office_branch_id')->nullable();
//         $table->string('office_id_number')->nullable();
//         $table->string('office_card_number')->nullable();
//         $table->string('office_IT_requirement')->nullable();
//         $table->string('office_work_schedule')->nullable();

//         // $table->integer('aggrement')->nullable();
//         $table->string('signature')->nullable();

//         $table->string('remember_token')->nullable();
//         $table->string('device_token')->nullable();
   
//         $table->timestamp('email_verified_at')->nullable();
//         $table->string('password');
//         $table->rememberToken();
//         $table->timestamps();
//     });

//     Schema::create('password_reset_tokens', function (Blueprint $table) {
//         $table->string('email')->primary();
//         $table->string('token');
//         $table->timestamp('created_at')->nullable();
//     });

//     Schema::create('sessions', function (Blueprint $table) {
//         $table->string('id')->primary();
//         $table->foreignId('user_id')->nullable()->index();
//         $table->string('ip_address', 45)->nullable();
//         $table->text('user_agent')->nullable();
//         $table->longText('payload');
//         $table->integer('last_activity')->index();
//     });
// }

// /**
//  * Reverse the migrations.
//  */
// public function down(): void
// {
//     Schema::dropIfExists('users');
//     Schema::dropIfExists('password_reset_tokens');
//     Schema::dropIfExists('sessions');
// }
};