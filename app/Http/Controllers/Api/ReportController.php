<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectCase;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportByMemberId(Request $request, $member = null)
    {
        // $valid = Validator::make($request->all(), [
        //     'member' => 'required|string'
        // ]);

        try {
            if ($request->ajax()) {
                if ($member == null) {
                    throw new Exception('member is required');
                }

                $user = User::where('username', $member)->first();

                $case = ProjectCase::where('project_member_id', $user->id)->with('users')->with('projects')->get();

                if (!$case->isEmpty()) {
                    return response()->json(['status' => 200, 'message' => 'report case success.', 'data' => $case], 200);
                }
                throw new Exception('not found');
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }

    public function reportProjectByMemberId(Request $request, $member = null)
    {
        try {
            // if ($request->ajax()) {

            // }
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'message' => $th->getMessage()], 500);
        }
    }
}
