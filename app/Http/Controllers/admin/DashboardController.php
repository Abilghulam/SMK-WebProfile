<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Nanti isi ringkasan (posts, docs, galleries, dll)
        return view('layouts.admin-pages.dashboard');
    }
}
