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
            'totalPhotos' => Image::count(),
            'photosSize' => $this->humanSize(Image::sum('size')),
            'totalNews' => News::count(),
            'totalSlides' => Baner::count(),
        ]);
    }

    public function humanSize($size) {
        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB'];

        for ($i = 0; $size > 1024; $i++) {
            $size /= 1024;
        }

        return round($size, 2) . ' ' . $units[$i];
    }
}
