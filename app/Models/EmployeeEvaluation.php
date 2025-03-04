<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeEvaluation extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'renewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function employe(){
        return $this->belongsTo(User::class,'emp_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'evaluated_by');
    }
}
