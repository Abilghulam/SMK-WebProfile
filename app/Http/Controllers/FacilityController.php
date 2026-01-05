<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category'); // null|indoor|outdoor

        $q = Facility::query()
            ->where('is_active', true);

        if (!empty($category)) {
            $q->where('category', $category);
        }

        $facilities = $q
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->get();

        // ambil kategori yang ada dari data aktif (biar dinamis)
        $categories = Facility::query()
            ->where('is_active', true)
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('components.user-pages.akademik.facility', compact('facilities', 'categories', 'category'));
    }
}
