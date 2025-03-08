<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function employe(){
        return $this->hasMany(Employee::class,'emp_bank_branch_id','id');
    }

    public function bankName(){
        return $this->belongsTo(BankName::class,'bank_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'bank_branch_creator');
    }
    public function editor(){
        return $this->belongsTo(User::class,'bank_branch_editor');
    }
}
