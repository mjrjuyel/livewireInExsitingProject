<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyReport extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'submit_date' => 'datetime',
    ];

    public function employe(){
        return $this->hasMany(Employee::class,'submit_by');
    }

}
