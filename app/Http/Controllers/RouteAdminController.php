<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\ProjectMember;
use App\Models\ProjectModel;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Generator;


class RouteAdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }

    public function project(Request $request)
    {
        $project = ProjectModel::where('id', $request->id)->first();
        $case = ProjectCase::where('project_id', $project->id)->where('project_member_id', $request->username)->orderBy('created_at', 'desc')->get();
        // $caseId = ProjectCase::where('project_id', $project->id)->pluck('id')->toArray();
        // $logtime = LogTime::whereIn('project_case_id', $caseId)->get();
        $member = ProjectMember::where('project_id', $project->id)->get();
        return view('project.project_home')->with('project', $project)->with('case', $case)->with('member', $member);
    }
}
