<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use HasFactory;

    // protected $table = 'project_members';

    protected $fillable = [
        'project_id',
        'user_id'
    ];

    protected $hidden = [
        'id',
    ];

    public $timestamps = false;

    public function caseDataFromMembers(){
        return $this->hasMany('App\Models\ProjectCase');
    }

    

    // public function projectTable()
    // {
    //     return $this->belongsTo(ProjectModel::class, );
    // }
}
