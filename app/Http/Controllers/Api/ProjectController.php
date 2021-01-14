<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectMemberModel;
use Illuminate\Http\Request;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $message = [
            'name.required' => 'The name field is required',
            'name.unique' => 'The name has already been taken',
            'description.required' => 'The description field is required',
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|unique:project_models,name|max:255',
            'description' => 'required|string|max:255',
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $project = new ProjectModel;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->project_code = $this->generateRandomString();
        $project->status = 1;
        $result = $project->save();

        if ($result) {
            $member = new ProjectMemberModel;
            $member->project_id = $project->id;
            $member->user_id = auth()->user()->id;
            $member->role = 'OWNER';
            $member->save();

            return response()->json(['status' => '200', 'message' => 'Create project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '500', 'message' => 'Create project error', 'errors' => 'Project not create'], 500);
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
            return response()->json(['status' => '500', 'message' => 'Get project error', 'errors' => 'Project not create'], 500);
        }
    }

    public function showAll(Request $request)
    {
        $project = ProjectModel::where('status', 1)->get();

        if ($project->isNotEmpty()) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '500', 'message' => 'Get project error', 'errors' => 'No project'], 500);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only',
            'name.required' => 'The name field is required',
            'name.string' => 'The name field type string only',
            'description.required' => 'The description field is required',
            'description.string' => 'The description type string only'
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|string|unique:project_models,name|max:255',
            'description' => 'required|string|max:255'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $id = $request->id;
        $project = ProjectModel::find($id);

        if ($project) {
            $project->name = $request->name;
            $project->name = $request->description;
            $result = $project->save();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Update success', 'data' => $project], 200);
            }else {
                return response()->json(['status' => '500', 'message' => 'Update error', 'errors' => 'Update project error'], 500);
            }
        }else {
            return response()->json(['status' => '500', 'message' => 'Get project error', 'errors' => 'No project'], 500);
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
            $project->status = 0;
            $result = $project->save();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Delete success'], 200);
            }else {
                return response()->json(['status' => '500', 'message' => 'Delete error', 'errors' => 'Delete project error'], 500);
            }
        }else {
            return response()->json(['status' => '500', 'message' => 'Delete errort', 'errors' => 'No project'], 500);
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


}


