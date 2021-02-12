<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Random extends Model
{
    protected $fillable = [
        'random_string'
    ];

    public $timestamps = false;
}
