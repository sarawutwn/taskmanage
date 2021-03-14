<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\ProjectMember;
use App\Models\ProjectModel;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Generator;

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

    public function project(Request $request)
    {
        $project = ProjectModel::where('id', $request->id)->first();
        $user = User::where('username', $request->username)->first();
        $case = ProjectCase::where('project_id', $project->id)->where('project_member_id', $user->id)->orderBy('created_at', 'desc')->get();
        // $caseId = ProjectCase::where('project_id', $project->id)->pluck('id')->toArray();
        // $logtime = LogTime::whereIn('project_case_id', $caseId)->get();
        $member = ProjectMember::where('project_id', $project->id)->get();
        return view('project.project_home')->with('project', $project)->with('case', $case)->with('member', $member);
    }

    public function checkin(Request $request)
    {
        $userCode = User::select('user_code')->where('username', $request->username)->first();
        $qrcode = new Generator;
        $qr = $qrcode->size(300)->generate("http://10.5.40.43:8000/submit=" . $userCode->user_code);
        return view('qrcode', [
            'qr' => $qr
        ]);
    }

    public function submitForm(Request $request)
    {
        return view('checkin');
    }
}
