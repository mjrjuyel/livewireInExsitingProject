<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CateringPayment extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'payment_date' => 'datetime',
    ];

    public function creatorUser(){
        return $this->belongsTo(User::class,'p_creator');
    }

    public function editorUser(){
        return $this->belongsTo(User::class,'p_editor');
    }
}
