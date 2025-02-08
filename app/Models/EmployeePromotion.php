<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeePromotion extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'pro_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function employe(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'depart_id','id');
    }
    public function designation(){
        return $this->belongsTo(Designation::class,'desig_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'promoted_by','id');
    }
}
