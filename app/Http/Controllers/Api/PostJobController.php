<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostJob;
use Illuminate\Support\Carbon;

class PostJobController extends Controller
{
    public function workInCheck(){
        $user = auth()->user();
        $postJob = PostJob::create([
            "user_id" => $user->id,
            "date" => Carbon::now(),
            "update_to_report" => false
        ]);

        if(!$postJob){
            return response()->json(['status' => '500', 'message' => "Try again."], 500);
        }else{
            return response()->json(['status' => '200', 'message' => "You are check 'work-in' successfully."], 200);
        }
    }

    public function getCheckIn(Request $request){
        $user = $request->user();
        $now = Carbon::now();
        $postJob = PostJob::where("user_id", $user->id)
                            ->orWhere('date', $now)->get();

        return response()->json(['status' => '200', 'message' => 'Get Check-in list successfully.', 'data' => $postJob], 200);
    }
}
