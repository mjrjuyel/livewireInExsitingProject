<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // For Api Call
    protected $appends = [
        'formatted_start_date',
        'formatted_end_date'
    ];

    public function getFormattedStartDateAttribute()
    {
        return $this->start_date ? $this->start_date->format('d-M-Y') : null;
    }
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date ? $this->end_date->format('d-M-Y') : null;
    }
    // 

    public function admin(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function employe(){
        return $this->belongsTo(User::class,'emp_id','id');
    }

    public function leavetype(){
        return $this->belongsTo(LeaveType::class,'leave_type_id','id');
    }
}
