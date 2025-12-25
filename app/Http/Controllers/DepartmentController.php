<?php

namespace App\Http\Controllers;

use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * List program keahlian
     */
    public function index()
    {
        $departments = Department::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('components.user-pages.akademik.departments', compact('departments'));
    }

    /**
     * Detail program keahlian
     */
    public function show(string $slug)
    {
        $department = Department::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('components.user-pages.akademik.department-detail', compact('department'));
    }
}
