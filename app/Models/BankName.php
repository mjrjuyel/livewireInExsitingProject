<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankName extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function employe(){
        return $this->hasMany(Employee::class,'emp_bank_name_id','id');
    }

    public function bankbranch(){
        return $this->hasMany(BankBranch::class,'bank_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'bank_creator');
    }
    public function editor(){
        return $this->belongsTo(User::class,'bank_editor');
    }
}
