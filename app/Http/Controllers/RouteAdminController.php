<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectCase;
use App\Models\ProjectMember;
use App\Models\ProjectModel;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Generator;


class RouteAdminController extends Controller
{

    public function index()
    {
        return view('admin.index');
    }
}
