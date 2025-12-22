<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;

class HomeController extends Controller
{
    public function index()
    {
        return view('layouts.user-pages.home', [
            'schoolProfile' => SchoolProfile::first()
        ]);
    }
}
