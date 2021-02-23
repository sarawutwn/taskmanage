<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    public function reportByMemberId(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'member_id' => 'required|string'
        ]);

        if ($valid->fails()) {
            return response()->json(['status' => 400, 'errors' => $valid->errors()], 400);
        }

        $memberId = $request->member_id;
        $case = ProjectCase::where('project_member_id', $memberId)->join('users', 'users.username', '=', 'project_member_id')
            ->join('project_models', 'project_models.id', '=', 'project_id')
            ->get(['project_cases.*', 'users.username', 'project_models.name as project_name']);
        if (!$case->isEmpty()) {
            return response()->json(['status' => 200, 'message' => 'report case success.', 'data' => $case], 200);
        }

        return response()->json(['status' => 404, 'message' => 'error case.'], 404);
    }
}
