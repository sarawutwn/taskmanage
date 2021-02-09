<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\LogTime;
use App\Models\ProjectCase;

class LogTimeController extends Controller
{
    public function startTime(Request $request){
        $data = $request->all();

        $message = [
            'project_case_id.required' => 'The project_case_id field is required'
        ];

        $validator = Validator::make($data,[
            'project_case_id' => 'required'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }else {
            $case = ProjectCase::where('id', $request->project_case_id)->with('dataFromLogTimes')->first();
            if($case->open_case_time == null){
                return response()->json(['status' => '400', 'message' => 'Case cannot open. Your cant start logtime!'],400);
            }else {
                $log = LogTime::where('project_case_id', $request->project_case_id)->where('work_end_time', '=', null)->first();
                if(!empty($log)){
                    return response()->json(['status' => '400','message' => 'Logtime of case is starting...', 'data' => $log], 400);
                }else {
                    $dateStart = Carbon::now();
                    $start = date('Y-m-d H:i:s',strtotime($dateStart));
                    $logTime = new LogTime;
                    $logTime->project_case_id = $request->project_case_id;
                    $logTime->work_start_time = $start;
                    $result = $logTime->save();

                    if($result){
                        return response()->json(['status' => '200', 'message' => 'Start working successfully.', 'data' => $logTime], 200);
                    }else {
                        return response()->json(['status' => '400', 'message' => 'Insert to database is errors!'], 400);
                    }
                }
            }
        }
    }

    public function endTime(Request $request){
        $data = $request->all();

        $message = [
            'project_case_id.required' => 'The project_case_id field is required',
            'detail.string' => 'Detail field type string only',
            'detail.required' => 'Detail field is Required!',
        ];

        $validator = Validator::make($data,[
            'project_case_id' => 'required',
            'detail' => 'string|required'
        ], $message);

        if ($validator->fails()) {
            return response()->json(['status' => '400', 'message' => 'Validator error', 'errors' => $validator->errors()], 400);
        }else {
            $logTime = LogTime::where('project_case_id', $request->project_case_id)->where('work_end_time', '=', null)->first();
            if(empty($logTime)){
                return response()->json(['status' => '400', 'message' => 'LogTime is not Starting...'], 400);
            }else {
                
                $date = Carbon::now();
                $end = date('Y-m-d H:i:s',strtotime($date));
                $endDate = new Carbon($end);
                $startDate = new Carbon($logTime->work_start_time);
                $diffTime = $startDate->diffInHours($endDate) . ':' . $startDate->diff($endDate)->format('%I:%S');
                error_log($diffTime);

                $logTime->detail = $request->detail;
                $logTime->work_end_time = $end;
                $logTime->total_working_time = $diffTime;
                $result = $logTime->save();

                if($result){
                    return response()->json(['status' => '200', 'message' => 'Logtime is Ending.', 'data' => $logTime], 200);
                }else {
                    return response()->json(['status' => '400', 'message' => 'Insert to database is errors!'], 400);
                }
            }
        }
    }
}
