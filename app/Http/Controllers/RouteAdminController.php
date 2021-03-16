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
        return view('admin.project.project_home')->with('project', $project);
    }

    public function checkin(Request $request)
    {
        $userCode = User::select('user_code')->where('username', $request->username)->first();
        $qrcode = new Generator;
        $qr = $qrcode->size(300)->generate("http://10.5.40.43:8000/submit=" . $userCode->user_code);
        return view('admin.qrcode', [
            'qr' => $qr
        ]);
    }

    public function editPage(Request $request)
    {
        $project = ProjectModel::where('id', $request->id)->first();
        return view('admin.project.edit_all_project')->with('project', $project);
    }
}
