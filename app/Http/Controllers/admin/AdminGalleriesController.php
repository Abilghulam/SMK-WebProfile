<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminGalleriesController extends Controller
{
    public function index(Request $request)
    {
        $q = Gallery::query()->withCount('items');

        // filter
        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');
        $category = trim((string) $request->query('category', 'all'));

        if ($search !== '') {
            $q->where(function ($w) use ($search) {
                $w->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($category !== '' && $category !== 'all') {
            $q->where('category', $category);
        }

        if ($status === 'published') {
            $q->where('is_published', true);
        } elseif ($status === 'draft') {
            $q->where('is_published', false);
        }

        $galleries = $q->orderByDesc('event_date')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        // kategori dropdown (optional kalau kamu ingin filter kategori nanti)
        $categories = Gallery::query()
            ->select('category')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin-pages.documentation.galleries.index', compact(
            'galleries',
            'categories',
            'search',
            'status',
            'category',
        ));
    }

    public function create()
    {
        $gallery = new Gallery();
        return view('admin-pages.documentation.galleries.create', compact('gallery'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
            'cover_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['is_published'] = (bool) ($data['is_published'] ?? true);

        // slug auto dari title bila kosong
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // upload cover
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('galleries', 'public');
            $data['cover_image'] = $path;
        }

        $gallery = Gallery::create($data);

        return redirect()
            ->route('admin.documentation.items.index', $gallery)
            ->with('success', 'Album dokumentasi berhasil dibuat. Silakan tambah item.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin-pages.documentation.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug,' . $gallery->id],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // upload cover (replace)
        if ($request->hasFile('cover_image')) {
            if (!empty($gallery->cover_image)) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            $path = $request->file('cover_image')->store('galleries', 'public');
            $data['cover_image'] = $path;
        }

        $gallery->update($data);

        return redirect()
            ->route('admin.documentation.galleries.edit', $gallery)
            ->with('success', 'Album berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        // hapus cover
        if (!empty($gallery->cover_image)) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        // hapus item file (kalau item disimpan di storage)
        $gallery->load('items');
        foreach ($gallery->items as $item) {
            if (!empty($item->path)) {
                Storage::disk('public')->delete($item->path);
            }
        }

        $gallery->delete();

        return redirect()
            ->route('admin.documentation.galleries.index')
            ->with('success', 'Album berhasil dihapus.');
    }

    public function togglePublish(Request $request, Gallery $gallery)
    {
        $gallery->is_published = !$gallery->is_published;
        $gallery->save(); // ini otomatis update updated_at

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'is_published' => (bool) $gallery->is_published,
                'updated_at' => optional($gallery->updated_at)->toIso8601String(),
            ]);
        }

        return back()->with('success', 'Status publikasi berhasil diperbarui.');
    }
}
