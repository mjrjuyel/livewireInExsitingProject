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
        return $this->belongsTo(Employee::class,'submit_by','id');
    }

    public function report_editor(){
        return $this->belongsTo(User::class,'editor','id');
    }

}
