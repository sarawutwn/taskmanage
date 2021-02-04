<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectMember extends Model
{
    use HasFactory, SoftDeletes;

    // protected $table = 'project_members';

    protected $fillable = [
        'project_id',
        'user_id'
    ];
    protected $dates = ['deleted_at'];

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
