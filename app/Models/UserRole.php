<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function admin(){
        return $this->hasMany(User::class,'role_id');
    }

    public function employe(){
        return $this->hasMany(User::class,'role_id');
    }
}