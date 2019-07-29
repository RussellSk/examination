<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\News;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        return view('pages.dashboard.index', [
            'totalClients' => 1,
            'totalUsers' => User::count(),
        ]);
    }


}
