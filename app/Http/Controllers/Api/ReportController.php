<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectCase;

class ReportController extends Controller
{
    public function reportByMemberId($member = null)
    {
        // $valid = Validator::make($request->all(), [
        //     'member' => 'required|string'
        // ]);

        if ($member == null) {
            return response()->json(['status' => 400, 'errors' => 'member is required'], 400);
        }

        $case = ProjectCase::where('project_member_id', $member)->with('users')->get();

        if (!$case->isEmpty()) {
            return response()->json(['status' => 200, 'message' => 'report case success.', 'data' => $case], 200);
        }

        return response()->json(['status' => 404, 'message' => 'error case.'], 404);
    }
}
