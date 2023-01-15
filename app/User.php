<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function orders(){
        return $this->hasMany(Order::class);
    }
    public function PaidAmount(){
        return $this->hasMany(PaidAmount::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function doctor(){
        return $this->hasOne('App\Model\Doctor');
    }
    public function pharma(){
        return $this->hasOne('App\Model\Pharma');
    }
    public function pharmacy(){
        return $this->hasOne('App\Model\Pharmacy');
    }

    protected $fillable = [
        'role_id','name', 'email', 'phone', 'password','status','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
