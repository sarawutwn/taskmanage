<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_case_id',
        'detail',
        'work_start_time',
        'work_end_time',
        'total_working_time',
    ];

    protected $hidden = [
        'id'
    ];

    public $timestamps = true;
}
