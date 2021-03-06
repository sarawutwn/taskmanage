<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProjectCase;
use App\Models\ProjectModel;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;

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
        $member = ProjectMember::where('project_id', $request->project_id)->where('username', $request->project_member_id)->first();
        if ($member == null) {
            return response()->json(['statue' => 400, 'message' => 'Add case is fail!', 'errors' => 'Not have member in project.'], 400);
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
        // $projects = ProjectMember::with('caseDataFromMembers')->orderBy('id')->get();
        $projects = ProjectModel::with('dataFromCases')->get();
        return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $projects], 200);
    }

    public function getCaseByProjectId(Request $request)
    {
        $data = $request->all();

        $message = [
            'projectId.required' => 'projectId field is required'
        ];

        $validator = Validator::make($data, [
            'projectId' => 'required'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        } else {
            $projects = ProjectCase::where('project_id', $request->projectId)->orderBy('id', 'desc')->get();

            if ($projects == null) {
                return response()->json(['status' => 400, 'message' => 'Is not have Project!'], 400);
            } else {
                return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $projects], 200);
            }
        }
    }

    public function getProjectFromCase(Request $request)
    {
        $data = $request->all();

        $message = [
            'caseId.required' => 'CaseId field is required'
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

    public function getCaseInProcess()
    {
        $project = ProjectModel::whereNull('deleted_at')->pluck('id')->toArray();
        $case = ProjectCase::whereIn('project_id', $project)->whereIn('status', ['opened', 'new'])->orderBy('id', 'desc')->get();
        return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $case], 200);
    }

    public function getCaseInProcessByProjectId(Request $request)
    {
        $data = $request->all();

        $message = [
            'projectId.required' => 'projectId field is required'
        ];

        $validator = Validator::make($data, [
            'projectId' => 'required'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        } else {
            $case = ProjectCase::whereIn('status', ['opened', 'new'])->where('project_id', $request->projectId)->orderBy('id', 'desc')->get();
            return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $case], 200);
        }
    }

    public function editCase(Request $request)
    {
        $data = $request->all();
        $now = Carbon::now();
        $message = [
            'name.required' => 'Name field is required',
            'name.max' => 'Name is max length of 255',
            'detail.required' => 'Detail field is required',
            'detail.max' => 'Detail is max length of 255',
            'end_case_time.required' => 'End case time field is required',
            'end_case_time.date' => 'End case time field type date only',
            'end_case_time.after' => 'End case time cant stay before ' . $now
        ];

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
            'end_case_time' => 'required|date|after:' . $now
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $id = $request->id;
        $case = ProjectCase::find($id);

        if ($case) {
            $case->name = $request->name;
            $case->detail = $request->detail;
            $case->end_case_time = $request->end_case_time;
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

                return response()->json(['status' => 200, 'message' => 'Case is opened.', 'data' => $case]);
            } else if ($case->status == "successfully") {
                return response()->json(['status' => 200, 'message' => 'Case is finished.', 'data' => $case], 200);
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

    public function readCase(Request $request)
    {
        $case = ProjectCase::where('id', $request->id)->first();
        return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $case], 200);
    }

    public function getCaseByToken(Request $request)
    {
        $token = $request->user();
        $project = ProjectModel::whereNull('deleted_at')->pluck('id')->toArray();
        $case = ProjectCase::whereIn('project_id', $project)->where('project_member_id', $token->username)->orderBy('updated_at', 'desc')->get();
        return response()->json(['status' => 200, 'message' => 'Get case by token successfully.', 'data' => $case]);
    }

    public function paginateCaseByToken(Request $request)
    {
        $token = $request->user();
        $project = ProjectModel::whereNull('deleted_at')->pluck('id')->toArray();
        $case = ProjectCase::whereIn('project_id', $project)->where('project_member_id', $token->username)->orderBy('created_at', 'desc')->paginate(5);
        return response()->json(['status' => 200, 'message' => 'Get case by token successfully.', 'data' => $case]);
    }

    public function paginateCaseByTokenWithViewMake(Request $request)
    {
        $token = $request->user();
        $project = ProjectModel::whereNull('deleted_at')->pluck('id')->toArray();
        $arrayData = ProjectCase::whereIn('project_id', $project)->where('project_member_id', $token->username)->orderBy('created_at', 'desc')->paginate(5);
        $view = View::make('table.case_index', compact('arrayData'))->render();
        return response()->json(['status' => 200, 'message' => 'Get case by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function AdminPaginateCaseByTokenWithViewMake(Request $request)
    {
        $token = $request->user();
        $project = ProjectModel::whereNull('deleted_at')->pluck('id')->toArray();
        $arrayData = ProjectCase::whereIn('project_id', $project)->where('project_member_id', $token->username)->orderBy('created_at', 'desc')->paginate(5);
        $view = View::make('admin.table.case_index', compact('arrayData'))->render();
        return response()->json(['status' => 200, 'message' => 'Get case by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function paginateCaseWhereProjectIdByToken(Request $request)
    {
        $token = $request->user();
        $case = ProjectCase::where('project_id', $request->projectId)->where('project_member_id', $token->username)->orderBy('created_at', 'desc')->paginate(5);
        return response()->json(['status' => 200, 'message' => 'Get case by token successfully.', 'data' => $case]);
    }

    public function paginateCaseWhereProjectIdByTokenWithViewMake(Request $request)
    {
        $token = $request->user();
        $arrayData = ProjectCase::where('project_id', $request->projectId)->where('project_member_id', $token->username)->orderBy('created_at', 'desc')->paginate(5);
        $view = View::make('table.case_project_home', compact('arrayData'))->render();
        return response()->json(['status' => 200, 'message' => 'Get case by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function AdminPaginateCaseWhereProjectIdByTokenWithViewMake(Request $request)
    {
        $token = $request->user();
        $arrayData = ProjectCase::where('project_id', $request->projectId)->where('project_member_id', $token->username)->orderBy('created_at', 'desc')->paginate(5);
        $view = View::make('admin.table.case_project_home', compact('arrayData'))->render();
        return response()->json(['status' => 200, 'message' => 'Get case by token successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function getStatusCount(Request $request)
    {
        $token = $request->user();
        $caseNew = ProjectCase::where('project_member_id', $token->username)->where('status', 'new')->count();
        $caseOpen = ProjectCase::where('project_member_id', $token->username)->where('status', 'opened')->count();
        $caseSuccess = ProjectCase::where('project_member_id', $token->username)->where('status', 'successfully')->count();

        return response()->json(['status' => 200, 'message' => 'Get status count successfully.', 'new' => $caseNew, 'open' => $caseOpen, 'success' => $caseSuccess]);
    }

    public function paginateCaseAll()
    {
        $arrayData = ProjectCase::orderBy('created_at', 'desc')->paginate(8);
        $view = View::make('admin.table.case_case_home', compact('arrayData'))->render();
        return response()->json(['status' => 200, 'message' => 'get all case successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    public function paginateCaseEdit(Request $request)
    {
        $role = $request->user()->role;
        if ($role == 'ADMIN') {
            $arrayData = ProjectCase::where('project_id', $request->projectId)->orderBy('created_at', 'desc')->paginate(5);
            $view = View::make('admin.table.case_all_project', compact('arrayData'))->render();
        } else {
            $arrayData = ProjectCase::where('project_id', $request->projectId)->orderBy('created_at', 'desc')->paginate(6);
            $view = View::make('support.table.case_edit_case', compact('arrayData'))->render();
        }

        return response()->json(['status' => 200, 'message' => 'get case successfully.', 'data' => $arrayData, 'html' => $view]);
    }

    // public function getCaseEndAndProcess()
    // {
    //     $process = ProjectCase::where('status', 'opened')->orWhere('status', 'new')->get();
    //     $ending = ProjectCase::where('status', 'successfully')->orderBy('id', 'desc')->get();
    //     $result = $ending->merge($process);
    //     return response()->json($result);
    // }
}
