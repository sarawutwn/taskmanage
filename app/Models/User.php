<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

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
        'user_code',
        'role'
    ];


    protected $hidden = [
        'password',
        'user_code',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    public function accessTokens()
    {
        return $this->hasMany('App\Models\OauthAccessToken');
    }

    public function postjobDatas()
    {
        return $this->hasMany('App\Models\PostJob');
    }

    public function postjobReports()
    {
        return $this->hasMany('App\Models\PostJobReport');
    }

    public function dataFromMembers()
    {
        return $this->hasMany('App\Models\ProjectMember', 'username', 'username');
    }
}
