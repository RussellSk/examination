<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\News;
use App\Models\Student;
use App\Models\Test;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {

        return view('pages.dashboard.index', [
            'totalUsers' => User::count(),
            'totalStudents' => Student::count(),
            'totalTests' => Test::count(),
        ]);
    }


}
