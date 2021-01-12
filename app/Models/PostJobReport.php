<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostJobReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'work_in',
        'work_out'
    ];
    
    protected $hidden = [
        'id'
    ];

    public $timestamps = false;

}
