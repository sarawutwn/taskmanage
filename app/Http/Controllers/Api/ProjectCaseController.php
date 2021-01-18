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
        return response()->json(['data' => $projects], 200);
    }
}
