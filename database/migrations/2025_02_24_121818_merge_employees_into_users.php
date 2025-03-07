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
        // Schema::table('users', function (Blueprint $table) {
        //     // Personal Information
        //     $table->string('email2')->nullable();
        //     $table->string('phone', 20)->nullable();
        //     $table->string('phone2', 20)->nullable();
        //     $table->string('address', 100)->nullable();
        //     $table->string('present', 100)->nullable();
        //     $table->string('emer_contact', 20)->nullable();
        //     $table->string('emer_name', 50)->nullable();
        //     $table->string('emer_relation', 100)->nullable();
        //     $table->date('dob')->nullable();
        //     $table->string('gender', 20)->nullable();
        //     $table->string('marriage', 20)->nullable();
        //     $table->integer('status')->default(1)->change();

        //     // Job Details
        //     $table->integer('report_manager')->nullable();
        //     $table->integer('depart_id')->nullable();
        //     $table->integer('desig_id')->nullable();
        //     $table->string('email')->nullable()->change();
        //     $table->string('emp_type')->nullable();
        //     $table->date('join_date')->nullable();
        //     $table->date('resign_date')->nullable();

        //     // Evaluation
        //     $table->date('eva_start_date')->nullable();
        //     $table->date('eva_end_date')->nullable();

        //     // Identity Verification
        //     $table->string('id_type')->nullable();
        //     $table->string('id_number')->nullable();

        //     // Education
        //     $table->string('rec_degree')->nullable();
        //     $table->string('rec_year')->nullable();

        //     // Bank Details
        //     $table->integer('bank_id')->nullable();
        //     $table->integer('bank_branch_id')->nullable();
        //     $table->string('bank_account_name')->nullable();
        //     $table->string('bank_account_number', 50)->nullable();
        //     $table->string('bank_swift_code')->nullable();
        //     $table->string('bank_sort_code')->nullable();
        //     $table->string('bank_routing_number')->nullable();
        //     $table->string('bank_country')->nullable();

        //     // Office Details
        //     $table->integer('office_branch_id')->nullable();
        //     $table->string('office_id_number')->nullable();
        //     $table->string('office_card_number')->nullable();
        //     $table->string('office_IT_requirement')->nullable();
        //     $table->string('office_work_schedule')->nullable();

        //     // Other Fields
        //     $table->string('signature')->nullable();
        //     $table->integer('creator')->nullable();
        //     $table->integer('editor')->nullable();
        //     $table->string('device_token')->nullable();
        //     // Drop unnecessary columns (adjust based on actual column names)
        //     $table->dropColumn(['role_id', 'designation_id','slug']);
        // });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop newly added columns in case of rollback
            $table->dropColumn([
                'phone', 'phone2', 'address', 'present', 'emer_contact', 'emer_name',
                'emer_relation', 'dob', 'gender', 'marriage', 'image', 'status',
                'report_manager', 'depart_id', 'desig_id', 'employment_type', 'join_date',
                'resign_date', 'eva_start_date', 'eva_end_date', 'id_type', 'id_number', 'rec_degree',
                'rec_year', 'bank_id', 'bank_branch_id', 'bank_account_name', 'bank_account_number',
                'bank_swift_code', 'bank_sort_code', 'bank_routing_number', 'bank_country',
                'office_branch_id', 'office_id_number', 'office_card_number', 'office_IT_requirement',
                'office_work_schedule', 'signature', 'creator', 'editor', 'device_token'
            ]);
        });
    }
};
