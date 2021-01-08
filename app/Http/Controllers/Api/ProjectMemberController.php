<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectMemberModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function getMemberByProjectId(Request $request)
    {
        $data = $request->all();

        $message  = [
            'projectId.required' => 'The Project field is required'
        ];

        $validator = Validator::make($data, [
            'projectId' => 'required'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'data' => $validator->errors()]);
        }
        $projectId = $request->projectId;
        $members = ProjectMemberModel::where('project_id', $projectId)->get();

        if ($members->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get user success', 'data' => $members]);
        }else {
            return response()->json(['status' => '500', 'message' => 'No user in project']);
        }
    }

    public function getMyProject()
    {
        $myId = auth()->user()->id;
        $projects = ProjectMemberModel::where('user_id', $myId)->get();
        return response()->json($projects->projectTable);

    }
}
