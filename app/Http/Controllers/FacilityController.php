<?php

namespace App\Http\Controllers;

use App\Models\Facility;

class FacilityController extends Controller
{
    /**
     * List fasilitas sekolah
     */
    public function index()
    {
        $facilities = Facility::orderBy('name')->get();

        return view('components.user-pages.akademik.facility', compact('facilities'));
    }
}
