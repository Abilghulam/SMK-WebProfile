<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryItemsController extends Controller
{
    public function index(Gallery $gallery)
    {
        $gallery->loadCount('items');

        $items = $gallery->items()
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        return view('admin-pages.documentation.items.index', compact('gallery', 'items'));
    }

    public function store(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'type' => ['required', 'in:image,video'],
            'caption' => ['nullable', 'string', 'max:255'],

            // upload file (image/video)
            'file' => ['required', 'file', 'max:5120'], // 5MB, bisa kamu naikkan
        ]);

        $file = $request->file('file');

        // validasi mime sesuai type
        if ($data['type'] === 'image') {
            $request->validate([
                'file' => ['mimes:jpg,jpeg,png,webp'],
            ]);
        } else {
            $request->validate([
                'file' => ['mimes:mp4,webm,ogg'],
            ]);
        }

        $dir = $data['type'] === 'image' ? 'gallery-items/images' : 'gallery-items/videos';
        $path = $file->store($dir, 'public');

        $maxSort = (int) $gallery->items()->max('sort_order');
        $sort = $maxSort + 1;

        $item = new GalleryItem();
        $item->gallery_id = $gallery->id;
        $item->type = $data['type'];
        $item->path = $path;
        $item->caption = $data['caption'] ?? null;
        $item->sort_order = $sort;
        $item->save();

        return back()->with('success', 'Item berhasil ditambahkan.');
    }

    public function update(Request $request, GalleryItem $item)
    {
        $data = $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

    if ($request->hasFile('image')) {
        Storage::disk('public')->delete($item->path);
        $path = $request->file('image')->store('gallery-items/images', 'public');
        $item->path = $path;
        $item->type = 'image';
    }

      $item->caption = $data['caption'] ?? null;
      $item->update($data);

    if ($request->expectsJson()) {
        return response()->json([
            'ok' => true,
            'id' => $item->id,
            'caption' => $item->caption,
            'type' => $item->type,
            'url' => $item->type === 'image' ? $item->url : null, // pastikan model punya accessor url
        ]);
    }

        return back()->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy(GalleryItem $item)
    {
        if (!empty($item->path)) {
            Storage::disk('public')->delete($item->path);
        }

        $item->delete();

        return back()->with('success', 'Item berhasil dihapus.');
    }
}
