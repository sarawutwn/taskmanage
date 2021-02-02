<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $message = [
            'name.required' => 'The name field is required',
            'description.max' => 'The description must be at least 255 characters'
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
            $member->user_id = auth()->user()->id;
            $member->role = 'OWNER';
            $member->save();

            return response()->json(['status' => '200', 'message' => 'Create project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '400', 'message' => 'Create project error', 'errors' => 'Project not create'], 400);
        }
    }

    public function show(Request $request)
    {
        $data = $request->all();

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only'
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $id = $request->id;
        $project = ProjectModel::find($id);

        if ($project) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '400', 'message' => 'Get project error', 'errors' => 'Project not create'], 400);
        }
    }

    public function showAll(Request $request)
    {
        $project = ProjectModel::whereNull('deleted_at')->OrderBy('id')->get();

        if ($project->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '400', 'message' => 'Get project error', 'errors' => 'No project'], 400);
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
            'description.max' => 'The description must be at least 255 characters'
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'max:255'
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
            }else {
                return response()->json(['status' => '400', 'message' => 'Update error', 'errors' => 'Update project error'], 400);
            }
        }else {
            return response()->json(['status' => '400', 'message' => 'Get project error', 'errors' => 'No project'], 400);
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
            'id' => 'required|integer'
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
            }else {
                return response()->json(['status' => '400', 'message' => 'Delete error', 'errors' => 'Delete project error'], 400);
            }
        }else {
            return response()->json(['status' => '400', 'message' => 'Delete error', 'errors' => 'No project'], 400);
        }
    }

    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getMemberOut(Request $request){
        $data = $request->all();
        
        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only'
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }else{
            $userAll = User::all();
            $user = User::whereHas('dataFromMembers', function ($query) use($request) {
                $query->where('project_id', 'like', $request->id);
            })->get();
            $diff = $userAll->diff($user);
            return response()->json(['status' => 200,'message' => 'Get memberOut successfully.','data' => $diff]);
        }
    }
}


