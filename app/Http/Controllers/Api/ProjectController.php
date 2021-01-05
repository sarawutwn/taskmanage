<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function get($id)
    {
        return response()->json(['status' => '200','massage' => $id],200);
    }

    public function insert(Request $request)
    {
        return response()->json(['status' => '200','massage' => 'project insert'],200);
    }

    public function edit($id)
    {
        return response()->json(['status' => '200','massage' => 'project edit'],200);
    }

    public function delete($id)
    {
        return response()->json(['status' => '200','massage' => 'project delete'],200);
    }
}
