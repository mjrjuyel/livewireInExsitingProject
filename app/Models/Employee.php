<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserRole;
use App\Models\Designation;
use App\Models\User;

class Employee extends Authenticatable
{
    use HasFactory,Notifiable;

    // protected $hidden = ['password', 'remember_token'];

    protected $guarded = [];
    
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'emp_join'   => 'datetime',
        'emp_dob'    => 'datetime',
        'emp_resign' => 'datetime',
    ];

    public function emp_role(){
        return $this->belongsTo(UserRole::class);
    }
    
    public function emp_desig(){
        return $this->belongsTo(Designation::class);
    }

    public function creator(){
        return $this->belongsTo(User::class,'emp_creator','id');
    }

    public function dailyreport(){
        return $this->hasMany(DailyReport::class);
    }

    public function reporting(){
        return $this->belongsTo(Employee::class,'emp_report_manager','id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'emp_depart_id','id');
    }
    
    public function officeBranch(){
        return $this->belongsTo(OfficeBranch::class,'emp_office_branch_id','id');
    }

    public function bankName(){
        return $this->belongsTo(BankName::class,'emp_bank_id','id');
    }

    public function bankBranch(){
        return $this->belongsTo(BankBranch::class,'emp_bank_branch_id','id');
    }

}
