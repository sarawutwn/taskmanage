<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostJobReport;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostJobReportController extends Controller
{
    public function getReport(Request $request){
        $user = $request->user();
        $report = User::with('postJobReports')->where("id", $user->id)->get();
        return response()->json(['status' => 200, 'message' => 'Get Report-CheckIn-Daily Successfully.', 'data' => $report], 200);
    }

    public function getReportAll(Request $request){
        $user = $request->user()->id;
        $report = User::with('postjobReports')->get();
        return response()->json(['status' => 200, 'message' => 'Get Report-CheckIn-Daily All Successfully.', 'data' => $report], 200);
    }
}
