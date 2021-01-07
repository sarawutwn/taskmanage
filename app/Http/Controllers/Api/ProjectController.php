<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\ProjectMemberModel;
use Illuminate\Http\Request;
use App\Models\ProjectModel;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        $message = [
            'name.required' => 'The name field is required',
            'description.required' => 'The description field is required',
            //'memberId.required' => 'The memberId field is required',
            //'memberId.integer' => 'The memberId field type int only'
        ];

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            //'memberId' => 'required|integer'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'data' => $validator->errors()], 400);
        }

        $project = new ProjectModel;
        $project->name = $request->name;
        $project->description = $request->description;
        $result = $project->save();

        if ($result) {
            $member = new ProjectMemberModel;
            $member->project_id = $project->id;
            $member->user_id = auth()->user()->id;
            $member->role = 'OWNER';
            $member->save();

            return response()->json(['status' => '200', 'message' => 'Create project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '500', 'message' => 'Create project error'], 500);
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
            return response()->json(['status' => '400', 'message' => 'Validator error', 'data' => $validator->errors()], 400);
        }

        $id = $request->id;
        $project = ProjectModel::find($id);

        if ($project) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '500', 'message' => 'Get project error'], 500);
        }
    }

    public function showAll(Request $request)
    {
        $project = ProjectModel::all();

        if ($project) {
            return response()->json(['status' => '200', 'message' => 'Get project success', 'data' => $project], 200);
        }else {
            return response()->json(['status' => '500', 'message' => 'Get project error'], 500);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $message = [
            'id.required' => 'The id field is required',
            'id.integer' => 'The id field type int only',
            'name.required' => 'The name field is required',
            'description.required' => 'The description field is required'
        ];

        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|max:255',
            'description' => 'required|max:255'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'data' => $validator->errors()], 400);
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
                return response()->json(['status' => '500', 'message' => 'Update error'], 500);
            }
        }else {
            return response()->json(['status' => '500', 'message' => 'No project'], 500);
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
            return response()->json(['status' => '400', 'message' => 'Validator error', 'data' => $validator->errors()], 400);
        }

        $id = $request->id;
        $project = ProjectModel::find($id);

        if ($project) {
            $result = $project->delete();

            if ($result) {
                return response()->json(['status' => '200', 'message' => 'Delete success'], 200);
            }else {
                return response()->json(['status' => '500', 'message' => 'Delete error'], 500);
            }
        }else {
            return response()->json(['status' => '500', 'message' => 'No project'], 500);
        }
    }


}


 // public function get($id)
    // {
    //     return response()->json(['status' => '200','massage' => $id],200);
    // }

    // public function insert(Request $request)
    // {
    //     return response()->json(['status' => '200','massage' => 'project insert'],200);
    // }

    // public function edit($id)
    // {
    //     return response()->json(['status' => '200','massage' => 'project edit'],200);
    // }

    // public function delete($id)
    // {
    //     return response()->json(['status' => '200','massage' => 'project delete'],200);
    // }
