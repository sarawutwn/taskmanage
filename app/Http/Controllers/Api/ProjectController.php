<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectMember;
use App\Models\ProjectModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $message = [
            'name.required' => 'The name field is required',
            'description.max' => 'The description must be at least 255 characters',
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'description' => 'max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $project = new ProjectModel;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->project_code = $this->generateRandomString();
        $result = $project->save();

        if ($result) {
            $member = new ProjectMember;
            $member->project_id = $project->id;
            $member->username = auth()->user()->username;
            $member->role = 'OWNER';
            $member->save();

            return response()->json(['status' => '200', 'message' => 'Create project success', 'data' => $project], 200);
        } else {
            return response()->json(['status' => '400', 'message' => 'Create project error', 'errors' => 'Project not create'], 400);
        }
    }

    public function show(Request $request)
    {
        $data = $request->all();

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only',
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $id = $request->id;
        $project = ProjectModel::find($id);

        if ($project) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $project], 200);
        } else {
            return response()->json(['status' => '400', 'message' => 'Get project error', 'errors' => 'Project not create'], 400);
        }
    }

    public function getByToken(Request $request)
    {
        $token = $request->user();
        $member = ProjectMember::where('username', $token->username)->pluck('project_id')->toArray();
        $project = ProjectModel::whereIn('id', $member)->orderBy('created_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => 'Get project by token successfully.', 'data' => $project]);
    }

    public function paginateByToken(Request $request)
    {
        $token = $request->user();
        $member = ProjectMember::where('username', $token->username)->pluck('project_id')->toArray();
        $project = ProjectModel::whereIn('id', $member)->orderBy('created_at', 'desc')->paginate(5);
        return response()->json(['status' => 200, 'message' => 'Get project by token successfully.', 'data' => $project]);
    }

    public function paginateByTokenWithViewMake(Request $request)
    {
        $token = $request->user();
        $arrayData = [];
        $data = [];
        $data['token'] = $token;
        $member = ProjectMember::where('username', $token->username)->pluck('project_id')->toArray();
        $project = ProjectModel::whereIn('id', $member)->orderBy('created_at', 'desc')->paginate(5);
        $data['project'] = $project;
        array_push($arrayData, $data);
        $view = View::make('table.project_index', compact('project', 'token'))->render();
        return response()->json(['status' => 200, 'message' => 'Get project by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function AdminPaginateByTokenWithViewMake(Request $request)
    {
        $token = $request->user();
        $arrayData = [];
        $data = [];
        $data['token'] = $token;
        $member = ProjectMember::where('username', $token->username)->pluck('project_id')->toArray();
        $project = ProjectModel::whereIn('id', $member)->orderBy('created_at', 'desc')->paginate(5);
        $data['project'] = $project;
        array_push($arrayData, $data);
        $view = View::make('admin.table.project_index', compact('project', 'token'))->render();
        return response()->json(['status' => 200, 'message' => 'Get project by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function showAll(Request $request)
    {
        $user = User::all();
        $count = $user->count();
        $project = ProjectModel::withCount('dataFromMembers')->whereNull('deleted_at')->OrderBy('id', 'desc')->get();

        if ($project->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'all-user' => $count, 'data' => $project], 200);
        } else {
            return response()->json(['status' => '400', 'message' => 'Get project error', 'errors' => 'Project not found'], 400);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $request->id;
        $project = ProjectModel::find($id);

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only',
            'name.required' => 'The name field is required',
            'name.string' => 'The name field type string only',
            'description.max' => 'The description must be at least 255 characters',
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        if ($project) {
            $project->name = $request->name;
            $project->description = $request->description;
            $result = $project->save();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Update success', 'data' => $project], 200);
            } else {
                return response()->json(['status' => '400', 'message' => 'Update error', 'errors' => 'Update project error'], 400);
            }
        } else {
            return response()->json(['status' => '400', 'message' => 'Get project error', 'errors' => 'Project not found'], 400);
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only',
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $id = $request->id;
        $project = ProjectModel::find($id);

        if ($project) {
            $result = $project->delete();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Delete success'], 200);
            } else {
                return response()->json(['status' => '400', 'message' => 'Delete error', 'errors' => 'Delete project error'], 400);
            }
        } else {
            return response()->json(['status' => '400', 'message' => 'Delete error', 'errors' => 'Project not found'], 400);
        }
    }

    public function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getMemberOut(Request $request)
    {
        $data = $request->all();

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only',
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        } else {
            $userAll = User::all();
            $user = User::whereHas('dataFromMembers', function ($query) use ($request) {
                $query->where('project_id', 'like', $request->id);
            })->get();
            $diff = $userAll->diff($user);
            return response()->json(['status' => 200, 'message' => 'Get memberOut successfully.', 'data' => $diff]);
        }
    }

    public function restore(Request $request)
    {
        $data = $request->all();

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only',
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $id = $request->id;
        $project = ProjectModel::withTrashed()->where('id', $id)->first();

        if ($project) {
            $result = $project->restore();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Restore success'], 200);
            } else {
                return response()->json(['status' => '400', 'message' => 'Restore error', 'errors' => 'Restore project error'], 400);
            }
        } else {
            return response()->json(['status' => '400', 'message' => 'Restore error', 'errors' => 'Project not found'], 400);
        }
    }

    public function paginateProjectAll(Request $request)
    {
        $role = $request->user()->role;

        if ($role == 'ADMIN') {
            $arrayData = ProjectModel::orderBy('created_at', 'desc')->paginate(8);
            $view = View::make('admin.table.project_all_project', compact('arrayData'))->render();
        } else {
            $arrayData = ProjectModel::orderBy('created_at', 'desc')->paginate(6);
            $view = View::make('support.table.project_all_project', compact('arrayData'))->render();
        }

        return response()->json(['status' => 200, 'message' => 'get paginate project all successfully.', 'data' => $arrayData, 'html' => $view]);
    }
}
