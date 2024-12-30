<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function admin(){
        return $this->hasMany(User::class,'designation_id');
    }

    public function employe(){
        return $this->hasMany(Employee::class,'emp_desig_id','id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'depart_id','id');
    }
}
