<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectMember;
use App\Models\ProjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProjectMemberController extends Controller
{
    public function getMemberByProjectId(Request $request)
    {
        $data = $request->all();

        $message = [
            'projectId.required' => 'The Project field is required',
            'projectId.integer' => 'The Project field type int only',
        ];

        $validator = Validator::make($data, [
            'projectId' => 'required|integer',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }
        $projectId = $request->projectId;
        $members = ProjectMember::where('project_id', $projectId)->join('users', 'users.username', '=', 'project_members.username')
            ->get(['users.username', 'users.firstname', 'users.lastname', 'project_members.role']);

        if ($members->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get user success', 'data' => $members], 200);
        } else {
            return response()->json(['status' => '500', 'message' => 'Get user error', 'errors' => 'No user in project'], 500);
        }
    }

    public function getMyProject()
    {
        $myId = auth()->user()->username;
        $projects = ProjectMember::where('username', $myId)->join('project_models', 'project_models.id', '=', 'project_members.project_id')->get(['project_models.*']);

        if ($projects->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $projects]);
        } else {
            return response()->json(['status' => '500', 'message' => 'Get project error', 'data' => 'User Project not found'], 500);
        }
    }

    public function getAllMember(Request $request)
    {
        if ($request->ajax()) {
            $searchText = $request->get('searchText');
            $users = User::where('username', 'like', "%$searchText%")->get(['id', 'username']);
            return response()->json(['status' => '200', 'message' => 'Get MemberAll success', 'data' => $users]);
        }
    }

    public function addMember(Request $request)
    {
        $data = $request->all();

        $message = [
            'projectId.required' => 'The ProjectMember Field is required',
            'projectId.integer' => 'The ProjectId field type int only',
            'username.required' => 'The Username Field is required ',
            'username.string' => 'The Username field type string only',
        ];

        $validator = Validator::make($data, [
            'projectId' => 'required|integer',
            'username' => 'required|string',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $projectId = $request->projectId;
        // $userId = $request->userId;
        $project = ProjectModel::find($projectId);
        $users = User::select('username')->where('username', $request->username)->first();
        $members = ProjectMember::where('project_id', $projectId)->where('username', $users->username)->get();

        if ($members->isEmpty() && $project) {
            $member = new ProjectMember;
            $member->project_id = $projectId;
            $member->username = $users->username;
            $member->role = "DEVELOPER";
            $result = $member->save();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Add member success']);
            }
            return response()->json(['status' => '500', 'message' => 'Add member error', 'errors' => 'Add member to project error'], 500);
        }

        if (!$project) {
            return response()->json(['status' => '400', 'message' => 'Add member error', 'errors' => 'Project not found'], 400);
        }

        if ($members->isNotEmpty()) {
            return response()->json(['status' => '400', 'message' => 'Add member error', 'errors' => 'User is exists'], 400);
        }
        return response()->json(['status' => '400', 'message' => 'Add member error', 'errors' => 'User and project is exists'], 400);
    }

    public function deleteMember(Request $request)
    {
        $data = $request->all();

        $message = [
            'projectId.required' => 'The ProjectMember Field is required',
            'projectId.integer' => 'The ProjectId field type int only',
            'username.required' => 'The Username Field is required ',
            'username.string' => 'The Username field type string only',
        ];

        $validator = Validator::make($data, [
            'projectId' => 'required|integer',
            'username' => 'required|string',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $projectId = $request->projectId;
        $username = $request->username;
        $project = ProjectModel::where('id', $projectId)->get();
        $user = User::select('id')->where('username', $username)->first();

        if ($project->isNotEmpty() && $user) {
            $result = ProjectMember::where('project_id', $projectId)->where('username', $username)->where('role', '!=', 'OWNER')->delete();
            error_log($result);
            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Delete member success'], 200);
            }
            return response()->json(['status' => '500', 'message' => 'Delete member error', 'errors' => 'Your owner'], 500);
        }

        if ($project->isEmpty() && $user) {
            return response()->json(['status' => '400', 'message' => 'Delete member error', 'errors' => 'Project not found'], 400);
        }

        if ($user && $project->isNotEmpty()) {
            return response()->json(['status' => '400', 'message' => 'Delete member error', 'errors' => 'No member'], 400);
        }
        return response()->json(['status' => '400', 'message' => 'Delete member error', 'errors' => 'No member and project'], 400);
    }

    public function paginateMemberWhereProjectIdByToken(Request $request)
    {
        $userCode = $request->user()->user_code;
        $user = User::where('user_code', $userCode)->first()->username;
        $role = ProjectMember::where('project_id', $request->projectId)->where('username', $user)->first()->role;
        $arrayData = ProjectMember::where('project_id', $request->projectId)->orderBy('id', 'asc')->paginate(5);
        $view = View::make('table.member_project_home', compact('arrayData', 'role'))->render();
        return response()->json(['status' => 200, 'message' => 'Get member by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function AdminPaginateMemberWhereProjectIdByToken(Request $request)
    {
        $userCode = $request->user()->user_code;
        $user = User::where('user_code', $userCode)->first()->username;
        $role = ProjectMember::where('project_id', $request->projectId)->where('username', $user)->first()->role;
        $arrayData = ProjectMember::where('project_id', $request->projectId)->orderBy('id', 'asc')->paginate(5);
        $view = View::make('admin.table.member_project_home', compact('arrayData', 'role'))->render();
        return response()->json(['status' => 200, 'message' => 'Get member by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function paginateMemberEdit(Request $request)
    {
        $arrayData = ProjectMember::where('project_id', $request->projectId)->orderBy('id', 'asc')->paginate(5);
        $view = View::make('admin.table.member_all_project', compact('arrayData'))->render();
        return response()->json(['status' => 200, 'message' => 'get member successfully.', 'data' => $arrayData, 'html' => $view]);
    }
}
