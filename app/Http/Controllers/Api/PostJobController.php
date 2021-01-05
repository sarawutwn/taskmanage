<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostJob;
use Carbon;

class PostJobController extends Controller
{
    public function workInCheck(Request $request){
        $user = $request->user();
        $postJob = PostJob::create([
            "user_id" => $user->id,
            "date" => Carbon::now(),
        ]);
        return response()->json(['status' => '200', 'message' => "You are check 'work-in' successfully."], 200);
    }

    public function getCheckIn(Request $request){
        $user = $request->user();
        $postJob = PostJob::all()->where("user_id", $user->id);
        return response()->json(['status' => '200', 'message' => 'Get Check-in list successfully.', 'data' => $postJob], 200);
    }
}
