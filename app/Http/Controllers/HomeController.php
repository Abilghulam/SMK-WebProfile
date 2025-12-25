<?php

namespace App\Http\Controllers;

use App\Models\SchoolProfile;
use App\Models\SchoolStatistic;
use App\Models\Principal;

class HomeController extends Controller
{
    public function index()
    {
        $schoolProfile = SchoolProfile::first();
        $statistic     = SchoolStatistic::first();
        $principal     = Principal::first();

        return view('layouts.user-pages.home', compact('schoolProfile', 'statistic', 'principal'));
    }

}
