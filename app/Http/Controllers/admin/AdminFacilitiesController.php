<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminFacilitiesController extends Controller
{
    public function index(Request $request)
    {
        $q = Facility::query();

        $search = trim((string) $request->query('q', ''));
        $category = (string) $request->query('category', 'all'); // all|indoor|outdoor
        $status = (string) $request->query('status', 'all');     // all|active|inactive

        if ($search !== '') {
            $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%");
            });
        }

        if ($category !== 'all' && $category !== '') {
            $q->where('category', $category);
        }

        if ($status === 'active') {
            $q->where('is_active', true);
        } elseif ($status === 'inactive') {
            $q->where('is_active', false);
        }

        $facilities = $q
            ->orderBy('sort_order')
            ->orderByDesc('updated_at')
            ->paginate(12)
            ->withQueryString();

        $categories = collect(Facility::CATEGORY_OPTIONS);

        return view('admin-pages.facilities.index', compact(
            'facilities',
            'categories',
            'search',
            'category',
            'status'
        ));
    }

    public function create()
    {
        $facility = new Facility();
        $categories = collect(Facility::CATEGORY_OPTIONS);

        return view('admin-pages.facilities.create', compact('facility', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('facilities', 'public');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        Facility::create($data);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        $categories = collect(Facility::CATEGORY_OPTIONS);

        return view('admin-pages.facilities.edit', compact('facility', 'categories'));
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            // hapus lama kalau ada
            if (!empty($facility->image)) {
                Storage::disk('public')->delete($facility->image);
            }

            $data['image'] = $request->file('image')->store('facilities', 'public');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $facility->update($data);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        if (!empty($facility->image)) {
            Storage::disk('public')->delete($facility->image);
        }

        $facility->delete();

        return back()->with('success', 'Fasilitas berhasil dihapus.');
    }

    public function toggleActive(Request $request, Facility $facility)
    {
        $facility->is_active = !$facility->is_active;
        $facility->save();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'is_active' => (bool) $facility->is_active,
                'updated_at' => optional($facility->updated_at)->toIso8601String(),
            ]);
        }

        return back()->with('success', 'Status fasilitas berhasil diperbarui.');
    }

    private function validated(Request $request): array
    {
        $categoryKeys = array_keys(Facility::CATEGORY_OPTIONS);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'category' => ['required', 'in:' . implode(',', $categoryKeys)],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);
    }
}
