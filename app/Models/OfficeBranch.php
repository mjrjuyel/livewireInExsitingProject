<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeBranch extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function employe(){
        return $this->hasMany(Employee::class,'emp_office_branch_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'branch_creator');
    }
    public function editor(){
        return $this->belongsTo(User::class,'branch_editor');
    }
}
