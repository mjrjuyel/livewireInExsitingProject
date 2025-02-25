<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EarlyLeave extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'leave_date' => 'datetime',
    ];

    public function admin(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function employe(){
        return $this->belongsTo(User::class,'emp_id','id');
    }

    public function leavetype(){
        return $this->belongsTo(LeaveType::class,'leave_type','id');
    }
}
