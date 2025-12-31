<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminPostsController extends Controller
{
    /**
     * GET /admin/posts
     */
    public function index(Request $request)
    {
        $type   = $request->query('type');   // news/agenda/achievement/...
        $status = $request->query('status'); // published/draft
        $q      = $request->query('q');      // cari title/slug

        $query = Post::query();

        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }

        if ($status && $status !== 'all') {
            if ($status === 'published') $query->where('is_published', 1);
            if ($status === 'draft')     $query->where('is_published', 0);
        }

        if ($q) {
            $query->where(function ($w) use ($q) {
                $w->where('title', 'like', "%{$q}%")
                  ->orWhere('slug', 'like', "%{$q}%");
            });
        }

        $posts = $query
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        // opsi filter type (bisa kamu tambah)
        $typeOptions = [
            'news'        => 'News',
            'agenda'      => 'Agenda',
            'achievement' => 'Achievement',
        ];

        return view('admin-pages.posts.index', compact('posts', 'type', 'status', 'q', 'typeOptions'));
    }

    /**
     * GET /admin/posts/create
     */
    public function create()
    {
        $typeOptions = [
            'news'        => 'News',
            'agenda'      => 'Agenda',
            'achievement' => 'Achievement',
        ];

        return view('admin-pages.posts.create', compact('typeOptions'));
    }

    /**
     * POST /admin/posts
     */
    public function store(Request $request)
    {
        $data = $this->validatePost($request);

        // slug: kalau kosong -> dari title
        $data['slug'] = $this->makeSlug(
            $data['slug'] ?? null,
            $data['title']
        );

        // publish rules
        $this->normalizePublishFields($data);

        // thumbnail upload (opsional)
        $data['thumbnail'] = $this->handleThumbnail($request, $data['thumbnail'] ?? null);

        Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post berhasil dibuat.');
    }

    /**
     * GET /admin/posts/{post}/edit
     */
    public function edit(Post $post)
    {
        $typeOptions = [
            'news'        => 'News',
            'agenda'      => 'Agenda',
            'achievement' => 'Achievement',
        ];

        return view('admin-pages.posts.edit', compact('post', 'typeOptions'));
    }

    /**
     * PUT /admin/posts/{post}
     */
    public function update(Request $request, Post $post)
    {
        $data = $this->validatePost($request, $post->id);

        // slug: kalau kosong -> dari title
        $data['slug'] = $this->makeSlug(
            $data['slug'] ?? null,
            $data['title'],
            $post->id
        );

        // publish rules
        $this->normalizePublishFields($data);

        // thumbnail upload (opsional)
        $data['thumbnail'] = $this->handleThumbnail($request, $data['thumbnail'] ?? $post->thumbnail);

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post berhasil diperbarui.');
    }

    /**
     * DELETE /admin/posts/{post}
     */
    public function destroy(Post $post)
    {
        // optional: kalau thumbnail disimpan di storage public dan mau dihapus file-nya
        // if ($post->thumbnail && Str::startsWith($post->thumbnail, 'posts/')) {
        //     Storage::disk('public')->delete($post->thumbnail);
        // }

        $post->delete();

        return back()->with('success', 'Post berhasil dihapus.');
    }

    // =========================
    // Helpers
    // =========================

    private function validatePost(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'type' => ['required', 'string', 'max:30'],

            'title' => ['required', 'string', 'max:255'],
            'slug'  => ['nullable', 'string', 'max:255', 'unique:posts,slug' . ($ignoreId ? ',' . $ignoreId : '')],

            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],

            // bisa URL/path
            'thumbnail' => ['nullable', 'string', 'max:255'],
            // atau upload
            'thumbnail_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'is_published' => ['nullable', 'boolean'],
            'is_featured'  => ['nullable', 'boolean'],

            'published_at' => ['nullable', 'date'],

            'event_start_at' => ['nullable', 'date'],
            'event_end_at'   => ['nullable', 'date', 'after_or_equal:event_start_at'],
            'location'       => ['nullable', 'string', 'max:255'],

            'level'      => ['nullable', 'string', 'max:80'],
            'awarded_at' => ['nullable', 'date'],
        ]);
    }

    private function makeSlug(?string $slugInput, string $title, ?int $ignoreId = null): string
    {
        $base = trim($slugInput ?: Str::slug($title));
        if ($base === '') $base = Str::slug(Str::random(8));

        $slug = $base;
        $i = 2;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    private function normalizePublishFields(array &$data): void
    {
        $data['is_published'] = !empty($data['is_published']) ? 1 : 0;
        $data['is_featured']  = !empty($data['is_featured']) ? 1 : 0;

        if ($data['is_published']) {
            // kalau published_at kosong, isi sekarang
            if (empty($data['published_at'])) {
                $data['published_at'] = now();
            } else {
                $data['published_at'] = Carbon::parse($data['published_at']);
            }
        } else {
            // draft -> published_at null
            $data['published_at'] = null;
        }
    }

    private function handleThumbnail(Request $request, ?string $fallback): ?string
    {
        if ($request->hasFile('thumbnail_file')) {
            $path = $request->file('thumbnail_file')->store('posts', 'public');
            return $path; // simpan path storage: posts/xxx.webp
        }

        return $fallback ?: null;
    }
}
