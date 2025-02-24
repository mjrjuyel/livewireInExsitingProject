<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,HasFactory,Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $timetamps = false;
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'username',
        'image',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function employe(){
        return $this->hasMany(User::class,'creator');
    }

    public function leave(){
        return $this->belongsTo(Leave::class,'user_id');
    }
    // Copy From Employee Model

    public function emp_desig(){
        return $this->belongsTo(Designation::class,'desig_id','id');
    }

    public function creator(){
        return $this->belongsTo(User::class,'creator','id');
    }

    public function dailyreport(){
        return $this->hasMany(DailyReport::class);
    }

    public function reporting(){
        return $this->belongsTo(User::class,'report_manager','id');
    }

    public function department(){
        return $this->belongsTo(Department::class,'depart_id','id');
    }
    
    public function officeBranch(){
        return $this->belongsTo(OfficeBranch::class,'office_branch_id','id');
    }

    public function bankName(){
        return $this->belongsTo(BankName::class,'bank_id','id');
    }

    public function bankBranch(){
        return $this->belongsTo(BankBranch::class,'bank_branch_id','id');
    }
}
