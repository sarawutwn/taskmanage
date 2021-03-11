<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'update_to_report'
    ];

    protected $hidden = [
        'id',
        'update_to_report'
    ];

    public $timestamps = false;
}
