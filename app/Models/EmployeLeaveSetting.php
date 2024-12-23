<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeLeaveSetting extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'speacialoffdate'=> 'datetime',
    ];

    public function admin(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function employe(){
        return $this->belongsTo(Employee::class,'emp_id','id');
    }

    public function leavetype(){
        return $this->belongsTo(LeaveType::class,'leave_type_id','id');
    }
}
