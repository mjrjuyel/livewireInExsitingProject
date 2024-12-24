<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CateringFood extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'order_date' => 'datetime',
    ];

    public function creator(){
        return $this->belongsTo(User::class,'creator');
    }

    public function report_editor(){
        return $this->belongsTo(User::class,'editor','id');
    }
}
