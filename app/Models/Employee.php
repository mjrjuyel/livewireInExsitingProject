<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserRole;
use App\Models\Designation;
use App\Models\User;

class Employee extends Authenticatable
{
    use HasFactory,Notifiable;

    // protected $hidden = ['password', 'remember_token'];

    protected $guarded = [];
    
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function emp_role(){
        return $this->belongsTo(UserRole::class);
    }
    
    public function emp_desig(){
        return $this->belongsTo(Designation::class);
    }

    public function creator(){
        return $this->belongsTo(User::class,'emp_creator','id');
    }

    public function dailyreport(){
        return $this->hasMany(DailyReport::class);
    }

}
