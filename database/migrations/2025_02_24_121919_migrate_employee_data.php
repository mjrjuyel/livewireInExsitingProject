<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Insert employees data into users
        // DB::statement("DELETE FROM users");

        // DB::statement(" INSERT INTO users (id, name, email, phone, phone2, address, present, 
        //                        emer_contact, emer_name, emer_relation, dob, gender, marriage, 
        //                        image, status, report_manager, depart_id, desig_id, 
        //                        emp_type, join_date , resign_date, eva_start_date, eva_end_date, 
        //                        id_type, id_number, rec_degree, rec_year, bank_id, bank_branch_id, 
        //                        bank_account_name, bank_account_number, bank_swift_code, bank_sort_code, 
        //                        bank_routing_number, bank_country, office_branch_id, office_id_number, 
        //                        office_card_number, office_IT_requirement, office_work_schedule, 
        //                        signature, creator, editor, password, remember_token, device_token, 
        //                        created_at, updated_at)
        //             SELECT id, emp_name, email, emp_phone, emp_phone2, emp_address, emp_present, 
        //                 emp_emer_contact, emp_emer_name, emp_emer_relation, emp_dob, gender, marriage, 
        //                 emp_image, emp_status, emp_report_manager, emp_depart_id, emp_desig_id, 
        //                 emp_type, emp_join, emp_resign, eva_start_date, eva_end_date, 
        //                 emp_id_type, emp_id_number, emp_rec_degree, emp_rec_year, emp_bank_id, emp_bank_branch_id, 
        //                 emp_bank_account_name, emp_bank_account_number, emp_bank_swift_code, emp_bank_sort_code, 
        //                 emp_bank_routing_number, emp_bank_country, emp_office_branch_id, emp_office_id_number, 
        //                 emp_office_card_number, emp_office_IT_requirement, emp_office_work_schedule, 
        //                 emp_signature, emp_creator, emp_editor, password, remember_token, device_token, 
        //                 created_at, updated_at
        //             FROM employees"
        //     );
    }

    public function down(): void
    {
        // Remove migrated data in case of rollback
        DB::statement("DELETE FROM users WHERE id IN (SELECT id FROM employees)");
    }
};