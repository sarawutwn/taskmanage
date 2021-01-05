<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    // use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'firstname',
        'lastname',
        'email',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function accessTokens(){
        return $this->hasMany('App\Models\OauthAccessToken');
    }

    public function postjobData(){
        return $this->hasMany('App\Models\PostJob');
    }
}
