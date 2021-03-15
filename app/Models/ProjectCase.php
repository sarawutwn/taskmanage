<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'project_member_id',
        'name',
        'detail',
        'start_case_time',
        'end_case_time',
        'open_case_time',
        'done_case_time'
    ];

    // protected $hidden = [
    //     'id'
    // ];
    public function projects()
    {
        return $this->belongsTo('App\Models\ProjectModel', 'project_id', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'id', 'project_member_id');
    }

    public function dataFromLogTimes()
    {
        return $this->hasMany('App\Models\LogTime', 'project_case_id', 'id');
    }

    public $timestamps = true;
}
