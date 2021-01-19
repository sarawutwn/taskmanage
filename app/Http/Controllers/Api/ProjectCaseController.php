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
    public function addCase(Request $request){
        $data = $request->all();
        $start_date = Carbon::now();

        $message = [
            'project_member_id.required' => 'The project_id field is required',
            'project_member_id.integer' => 'The project_id field type int only',
            'name.required' => 'Name field is required',
            'name.max' => 'Name is max length of 255',
            'detail.required' => 'Detail field is required',
            'detail.max' => 'Detail is max length of 255',
            'end_date_case.' => 'End_Date field is required',
            'end_date_case.before' => 'End_date can start after '.$start_date
        ];

        $validator = Validator::make($data,[
            'project_member_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
            'end_date_case' => 'required|date|date_format:Y-m-d H:i:s|after:'.$start_date
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $StartDate = strtotime($start_date);
        $dateStart = date('Y-m-d H:i:s',$StartDate);

        $EndDate = strtotime($request->end_date_case);
        $dateEnd = date('Y-m-d H:i:s',$EndDate);

        $result = ProjectCase::create([
            'project_member_id' => $request->project_member_id,
            'name' => $request->name,
            'detail' => $request->detail,
            'start_date_case' => $dateStart,
            'end_date_case' => $dateEnd,
            'finished' => false
        ]);

        if($result){
            return response()->json(['status' => 200, 'message' => 'Add case is successfully.', 'data' => $result], 200);
        }else {
            return response()->json(['statue' => 500, 'message' => 'Add case is fail!', 'errors' => 'Case not create in datebase.'], 500);
        }
    }

    public function getCaseNotFinished(){
        $user = auth()->user()->id;
        $projects = ProjectMember::with('caseDataFromMembers')->where('user_id', $user)->get();
        return response()->json(['status' => 200,'message' => 'get case successfully.','data' => $projects], 200);
    }

    public function getAll(){
        $user = auth()->user()->id;
        $projects = ProjectMember::with('caseDataFromMembers')->get();
        return response()->json(['status' => 200,'message' => 'get case successfully.','data' => $projects], 200);
    }

    public function editCase(Request $request){
        $data = $request->all();
        $start_date = Carbon::now();

        $message = [
            'name.required' => 'Name field is required',
            'name.max' => 'Name is max length of 255',
            'detail.required' => 'Detail field is required',
            'detail.max' => 'Detail is max length of 255',
            'end_date_case.' => 'End_Date field is required',
            'end_date_case.before' => 'End_date can start after '.$start_date
        ];
        
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
            'end_date_case' => 'required|date|date_format:Y-m-d H:i:s|after:'.$start_date
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }

        $EndDate = strtotime($request->end_date_case);
        $dateEnd = date('Y-m-d H:i:s',$EndDate);

        $id = $request->id;
        $case = ProjectCase::find($id);

        if($case){
            $case->name = $request->name;
            $case->detail = $request->detail;
            $case->end_date_case = $dateEnd;
            $result = $case->save();

            if($result){
                return response()->json(['status' => 200, 'message' => 'Update case successfully.', 'data' => $result], 200);
            }else {
                return response()->json(['status' => 400, 'message' => 'Cant update because data type not compatible.'], 400);
            }
        }return response()->json(['status' => 500, 'message' => 'Update case errors!', 'errors' => 'client not have request.(id for case)'], 500);
    }

    public function deleteCase(Request $request){
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
        }else {
            return response()->json(['status' => '500', 'message' => 'Delete error!', 'errors' => 'Client not have request. (id case)'], 500);
        }
    }

    public function acceptCase(Request $request){
        $id = $request->id;
        $case = ProjectCase::find($id);
        if(!$id){
            return response()->json(['status' => 400, 'message' => 'Error request.', 'errors' => 'Client not have request. (id)'], 400);
        }else if(!$case){
                return response()->json(['status' => 404, 'message' => 'error object your request.', 'errors' => 'id not have data in database.'], 404);
            }else {
                if($case->finished){
                    return response()->json(['status' => 400, 'message' => 'error object your request.', 'errors' => 'data is Accept!'], 400);
                }else {
                    $case->finished = true;
                    $result = $case->save();
                    return response()->json(['status' => 200, 'message' => 'Accept your case successfully.', 'data' => $case], 200);
                }            
            }
        }
}
