<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_member_id',
        'name',
        'detail',
        'start_date_case',
        'end_date_case',
        'finished'
    ];

    protected $hidden = [
        'id'
    ];

    public $timestamps = false;
}
