<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    public function employe(){
        return $this->hasMany(Employee::class,'emp_depart_id','id');
    }

    public function designation(){
        return $this->hasMany(Designation::class,'depart_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'depart_creator');
    }
    public function editor(){
        return $this->belongsTo(User::class,'depart_editor');
    }
}
