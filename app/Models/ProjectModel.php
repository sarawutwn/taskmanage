<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'project_code'
    ];

    protected $dates = ['deleted_at'];

    public function dataFromMembers()
    {
        return $this->hasMany('App\Models\ProjectMember', 'project_id', 'id');
    }

    public function dataFromCases()
    {
        return $this->hasMany('App\Models\ProjectCase', 'project_id', 'id')->orderBy('id', 'DESC');
    }
}
