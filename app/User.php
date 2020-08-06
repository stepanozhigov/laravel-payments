<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','secret_key','balance'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','secret_key','email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function xyzpayments_sent() {
        return $this->hasMany('App\XYZPayment','sender_id');
    }
    public function xyzpayments_received() {
        return $this->hasMany('App\XYZPayment','recipient_id');
    }

    public function generateToken()
    {
        $this->secret_key = Str::random(60);
        $this->save();

        return $this->secret_key;
    }
}
