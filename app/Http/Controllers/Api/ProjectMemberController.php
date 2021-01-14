<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectMemberModel;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function getMemberByProjectId(Request $request)
    {
        $data = $request->all();

        $message  = [
            'projectId.required' => 'The Project field is required',
            'projectId.integer' => 'The Project field type int only'
        ];

        $validator = Validator::make($data, [
            'projectId' => 'required|integer'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }
        $projectId = $request->projectId;
        $members = ProjectMemberModel::where('project_id', $projectId)->join('users', 'users.id', '=', 'project_members.user_id')
                                        ->get(['users.username', 'users.firstname', 'users.lastname', 'project_members.role']);

        if ($members->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get user success', 'data' => $members], 200);
        }else {
            return response()->json(['status' => '500', 'message' => 'Get user error', 'errors' => 'No user in project'], 500);
        }
    }

    public function getMyProject()
    {
        $myId = auth()->user()->id;
        $projects = ProjectMemberModel::where('user_id', $myId)->join('project_models', 'project_models.id', '=', 'project_members.project_id')->get(['project_models.*']);

        if ($projects->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $projects]);
        }else {
            return response()->json(['status' => '500', 'message' => 'Get project error', 'data' => 'User no project'], 500);
        }

    }

    public function addMember(Request $request)
    {
        $data = $request->all();

        $message = [
            'projectId.required' => 'The ProjectMember Field is required',
            'projectId.integer' => 'The ProjectId field type int only',
            'userId.required' => 'The UserId Field is required ',
            'userId.integer' => 'The UserId field type int only'
        ];

        $validator = Validator::make($data,[
            'projectId' => 'required|integer',
            'userId' => 'required|integer'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $projectId = $request->projectId;
        $userId = $request->userId;
        $project = ProjectModel::find($projectId);
        $members = ProjectMemberModel::where('project_id' , $projectId)->orWhere('user_id' , $userId)->get();

        if ($members->isEmpty() && $project) {
            $member = new ProjectMemberModel;
            $member->project_id = $projectId;
            $member->user_id = $userId;
            $member->role = "DEVELOPER";
            $result = $member->save();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Add member success']);
            }
            return response()->json(['status' => '500', 'message' => 'Add member error', 'errors' => 'Add member to project error'], 500);
        }

        if (!$project) {
            return response()->json(['status' => '500', 'message' => 'Add member error', 'errors' => 'No project'], 500);
        }
        return response()->json(['status' => '500', 'message' => 'Add member error', 'errors' => 'User is exists'], 500);
    }

}
