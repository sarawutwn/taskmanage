<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectModel;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Generator;

class RouteSupportController extends Controller
{
    public function index()
    {
        return view('support.index');
    }

    public function checkin(Request $request)
    {
        $userCode = User::select('user_code')->where('username', $request->username)->first();
        $qrcode = new Generator;
        $qr = $qrcode->size(300)->generate("http://10.5.40.16:8000/submit=" . $userCode->user_code);
        return view('support.qrcode', [
            'qr' => $qr
        ]);
    }

    public function editPage(Request $request)
    {
        $project = ProjectModel::where('id', $request->id)->first();
        return view('support.case.edit_case_project')->with('project', $project);
    }
}
