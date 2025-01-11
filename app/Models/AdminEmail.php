<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminEmail extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function creator(){
        return $this->belongsTo(User::class,'bank_branch_creator');
    }
    public function editor(){
        return $this->belongsTo(User::class,'bank_branch_editor');
    }
}
