<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProjectCase;
use App\Models\ProjectModel;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ProjectCaseController extends Controller
{
    public function addCase(Request $request)
    {
        $data = $request->all();
        $now = Carbon::yesterday();
        $message = [
            'project_id.required' => 'The project_id field is required',
            'project_id.integer' => 'The project_id field type int only',
            'project_member_id.required' => 'The project_member_id field is required',
            'project_member_id.string' => 'The project_member_id field type string only',
            'name.required' => 'Name field is required',
            'name.max' => 'Name is max length of 255',
            'detail.required' => 'Detail field is required',
            'detail.max' => 'Detail is max length of 255',
            'end_case_time.required' => 'End case time field is required',
            'end_case_time.date' => 'End case time field type date only',
            'end_case_time.after' => 'End case time cant stay before ' . $now
        ];

        $validator = Validator::make($data, [
            'project_id' => 'required|integer',
            'project_member_id' => 'required|string',
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
            'end_case_time' => 'required|date|after:' . $now
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }
        $day = Carbon::today();
        $dateTime = date('Y-m-d H:i:s', strtotime($day));
        $date = $request->end_case_time;
        $setTime = "23:59:59";
        $endTime = date('Y-m-d H:i:s', strtotime($date . $setTime));
        $result = ProjectCase::create([
            'project_id' => $request->project_id,
            'project_member_id' => $request->project_member_id,
            'name' => $request->name,
            'detail' => $request->detail,
            'start_case_time' => $dateTime,
            'end_case_time' => $endTime
        ]);

        if ($result) {
            return response()->json(['status' => 200, 'message' => 'Add case is successfully.', 'data' => $result], 200);
        } else {
            return response()->json(['statue' => 500, 'message' => 'Add case is fail!', 'errors' => 'Case not create in datebase.'], 500);
        }
    }

    public function getCaseById()
    {
        $user = auth()->user()->usermane;
        $projects = ProjectMember::with('caseDataFromMembers')->where('username', $user)->orderBy('id')->get();
        return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $projects], 200);
    }

    public function getAll()
    {
        $projects = ProjectMember::with('caseDataFromMembers')->orderBy('id')->get();
        return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $projects], 200);
    }

    public function getProjectFromCase(Request $request)
    {
        $data = $request->all();

        $message = [
            'caseId.required' => 'ProjectId field is required'
        ];

        $validator = Validator::make($data, [
            'caseId' => 'required'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        } else {
            $case = ProjectCase::where('id', $request->caseId)->first();
            if ($case == null) {
                return response()->json(['status' => 400, 'message' => 'Is not have Case!'], 400);
            } else {
                $project = ProjectModel::whereHas('dataFromMembers', function ($query) use ($case) {
                    $query->where('username', 'like', $case->project_member_id);
                })->get();
                return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $project], 200);
            }
        }
    }

    public function editCase(Request $request)
    {
        $data = $request->all();

        $message = [
            'name.required' => 'Name field is required',
            'name.max' => 'Name is max length of 255',
            'detail.required' => 'Detail field is required',
            'detail.max' => 'Detail is max length of 255'
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $id = $request->id;
        $case = ProjectCase::find($id);

        if ($case) {
            $case->name = $request->name;
            $case->detail = $request->detail;
            $result = $case->save();

            if ($result) {
                return response()->json(['status' => 200, 'message' => 'Update case successfully.', 'data' => $case], 200);
            } else {
                return response()->json(['status' => 400, 'message' => 'Cant update because data type not compatible.'], 400);
            }
        }
        return response()->json(['status' => 400, 'message' => 'Update case errors!', 'errors' => 'client not have request.(id for case)'], 400);
    }

    public function deleteCase(Request $request)
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
        $case = ProjectCase::find($id);

        if ($case) {
            $result = $case->delete();
            return response()->json(['status' => '200', 'message' => 'Delete case successfully.'], 200);
        } else {
            return response()->json(['status' => '500', 'message' => 'Delete error!', 'errors' => 'Client not have request. (id case)'], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $case = ProjectCase::find($id);
        if (!$id) {
            return response()->json(['status' => 400, 'message' => 'Error request.', 'errors' => 'Client not have request. (id)'], 400);
        } else if (!$case) {
            return response()->json(['status' => 404, 'message' => 'error object your request.', 'errors' => 'ID not have data in database.'], 404);
        } else {
            if ($case->status == "successfully") {
                return response()->json(['status' => 400, 'message' => 'error object your request.', 'errors' => 'Case is Finished!'], 400);
            } else if ($case->status == "new") {
                return response()->json(['status' => 400, 'message' => 'error object your request.', 'errors' => 'Case is not Start!'], 400);
            } else {
                $date = Carbon::now();
                $dateTime = date('Y-m-d H:i:s', strtotime($date));
                $case->done_case_time = $dateTime;
                $case->status = "successfully";
                $case->save();
                return response()->json(['status' => 200, 'message' => 'Accept your case successfully.', 'data' => $case], 200);
            }
        }
    }

    public function openCase(Request $request)
    {
        $id = $request->id;
        $case = ProjectCase::find($id);
        if (!$id) {
            return response()->json(['status' => 400, 'message' => 'Error request.', 'errors' => 'Client not have request. (id)'], 400);
        } else if (!$case) {
            return response()->json(['status' => 404, 'message' => 'error object your request.', 'errors' => 'ID not have data in database.'], 404);
        } else {
            if ($case->status == "opened") {
                return response()->json(['status' => 400, 'message' => 'error object your request.', 'errors' => 'Case is Opened!'], 400);
            } else if ($case->status == "successfully") {
                return response()->json(['status' => 200, 'message' => 'Case is finished!'], 200);
            } else {
                $date = Carbon::now();
                $dateTime = date('Y-m-d H:i:s', strtotime($date));
                $case->open_case_time = $dateTime;
                $case->status = "opened";
                $case->save();
                return response()->json(['status' => 200, 'message' => 'your case is started.', 'data' => $case], 200);
            }
        }
    }
}
