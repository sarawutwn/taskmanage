<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostJobReport;

class PostJobReportController extends Controller
{
    public function getReport(Request $request){
        $user = $request->user();
        $report = PostJobReport::where("user_id", $user->id)->get();
        return response()->json(['status' => 200, 'message' => 'Get Report-CheckIn-Daily Successfully.', 'data' => $report], 200);
    }

    public function getReportAll(){
        $report = PostJobReport::all();
        return response()->json(['status' => 200, 'message' => 'Get Report-CheckIn-Daily All Successfully.', 'data' => $report], 200);
    }
}
