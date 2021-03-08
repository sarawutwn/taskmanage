<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\ProjectMember;
use App\Models\ProjectModel;
<<<<<<< Updated upstream
=======
use App\Models\User;
use Illuminate\Support\Facades\Auth;
>>>>>>> Stashed changes

class RouteController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function index(Request $request)
    {
        return view('index');
    }
    public function project(Request $request)
    {
        $project = ProjectModel::where('id', $request->id)->first();
<<<<<<< Updated upstream
        $case = ProjectCase::where('project_id', $project->id)->get();
=======
        $user = User::where('username', $request->username)->first();
        $case = ProjectCase::where('project_id', $project->id)->where('project_member_id', $user->id)->orderBy('created_at', 'desc')->get();
        // $caseId = ProjectCase::where('project_id', $project->id)->pluck('id')->toArray();
        // $logtime = LogTime::whereIn('project_case_id', $caseId)->get();
>>>>>>> Stashed changes
        $member = ProjectMember::where('project_id', $project->id)->get();
        return view('project.project_home')->with('project', $project)->with('case', $case)->with('member', $member);
    }
}
