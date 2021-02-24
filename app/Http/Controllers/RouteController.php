<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\ProjectMember;
use App\Models\ProjectModel;

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
        $case = ProjectCase::where('project_id', $project->id)->get();
        $member = ProjectMember::where('project_id', $project->id)->get();
        return view('project.project_home')->with('project', $project)->with('case', $case)->with('member', $member);
    }
}
