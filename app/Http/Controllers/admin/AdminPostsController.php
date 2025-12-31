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
     * Hard rules: type yang diizinkan + mapping field aktif per type
     * Sesuaikan key sesuai value di DB (news/agenda/achievement/dll).
     */
    private const ALLOWED_TYPES = ['news', 'agenda', 'achievement'];

    /**
     * Field yang relevan untuk tiap type.
     * Yang tidak relevan akan di-null-kan agar data rapi dan aman.
     */
    private const TYPE_FIELDS = [
        'news' => [
            // konten umum
            'title', 'slug', 'excerpt', 'content', 'thumbnail',
            'is_published', 'is_featured', 'published_at',
            // tidak pakai event/award
        ],
        'agenda' => [
            'title', 'slug', 'excerpt', 'content', 'thumbnail',
            'is_published', 'is_featured', 'published_at',
            'event_start_at', 'event_end_at', 'location',
        ],
        'achievement' => [
            'title', 'slug', 'excerpt', 'content', 'thumbnail',
            'is_published', 'is_featured', 'published_at',
            'level', 'awarded_at',
        ],
    ];

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
            $q = trim($q);
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

        $typeOptions = [
            'news'        => 'Berita',
            'agenda'      => 'Agenda',
            'achievement' => 'Prestasi',
        ];

        return view('admin-pages.posts.index', compact('posts', 'type', 'status', 'q', 'typeOptions'));
    }

    /**
     * GET /admin/posts/create
     */
    public function create()
    {
        $typeOptions = [
            'news'        => 'Berita',
            'agenda'      => 'Agenda',
            'achievement' => 'Prestasi',
        ];

        return view('admin-pages.posts.create', compact('typeOptions'));
    }

    /**
     * POST /admin/posts
     */
    public function store(Request $request)
    {
        $data = $this->validatePost($request);

        // slug auto (unik)
        $data['slug'] = $this->makeSlug(
            $data['slug'] ?? null,
            $data['title']
        );

        // Upload thumbnail (hanya dari file)
        $data['thumbnail'] = $this->handleThumbnailUpload($request, null);

        // Normalisasi publish/draft + featured
        $this->normalizePublishFields($data);

        // Hardening: field yang tidak relevan -> null
        $this->nullifyUnusedFieldsByType($data);

        // Hardening: sanitasi konten minimal (opsional; boleh kamu matikan kalau pakai editor HTML + purifier)
        $data['excerpt'] = $this->sanitizeText($data['excerpt'] ?? null);
        $data['content'] = $this->sanitizeHtmlLoose($data['content'] ?? null);

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
            'news'        => 'Berita',
            'agenda'      => 'Agenda',
            'achievement' => 'Prestasi',
        ];

        return view('admin-pages.posts.edit', compact('post', 'typeOptions'));
    }

    /**
     * PUT /admin/posts/{post}
     */
    public function update(Request $request, Post $post)
    {
        $data = $this->validatePost($request, $post->id);

        // slug auto (unik)
        $data['slug'] = $this->makeSlug(
            $data['slug'] ?? null,
            $data['title'],
            $post->id
        );

        // Upload thumbnail (hapus lama jika diganti)
        $data['thumbnail'] = $this->handleThumbnailUpload($request, $post->thumbnail);

        // Normalisasi publish/draft + featured
        $this->normalizePublishFields($data);

        // Hardening: field yang tidak relevan -> null
        $this->nullifyUnusedFieldsByType($data);

        // Hardening: sanitasi konten minimal
        $data['excerpt'] = $this->sanitizeText($data['excerpt'] ?? null);
        $data['content'] = $this->sanitizeHtmlLoose($data['content'] ?? null);

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
        $this->deleteThumbnailIfStored($post->thumbnail);

        $post->delete();

        return back()->with('success', 'Post berhasil dihapus.');
    }

    // =========================================================
    // Validation + Helpers (Hardening)
    // =========================================================

    private function validatePost(Request $request, ?int $ignoreId = null): array
    {
        // ⚠️ IMPORTANT: jangan terima input thumbnail string (hanya upload)
        // Kalau di request ada 'thumbnail', kita abaikan nanti.

        $rules = [
            'type'  => ['required', 'string', 'in:' . implode(',', self::ALLOWED_TYPES)],
            'title' => ['required', 'string', 'max:255'],

            'slug' => [
                'nullable', 'string', 'max:255',
                'unique:posts,slug' . ($ignoreId ? ',' . $ignoreId : ''),
            ],

            'excerpt' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],

            'thumbnail_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            'is_published' => ['nullable', 'boolean'],
            'is_featured'  => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],

            'event_start_at' => ['nullable', 'date'],
            'event_end_at'   => ['nullable', 'date', 'after_or_equal:event_start_at'],
            'location'       => ['nullable', 'string', 'max:255'],

            'level'      => ['nullable', 'string', 'max:80'],
            'awarded_at' => ['nullable', 'date'],
        ];

        // Conditional hard rules per type (server-side)
        $type = $request->input('type');

        if ($type === 'agenda') {
            // agenda butuh tanggal event (minimal start)
            $rules['event_start_at'] = ['required', 'date'];
            // end boleh kosong tapi kalau ada harus >= start (sudah di rule)
            $rules['location'] = ['nullable', 'string', 'max:255'];
        }

        if ($type === 'achievement') {
            // prestasi lebih “rapi” kalau ada tanggal penghargaan
            $rules['awarded_at'] = ['required', 'date'];
            $rules['level'] = ['nullable', 'string', 'max:80'];
        }

        $data = $request->validate($rules);

        // buang input berbahaya / tidak dipakai
        unset($data['thumbnail']); // kalau user nakal kirim via form
        return $data;
    }

    private function makeSlug(?string $slugInput, string $title, ?int $ignoreId = null): string
    {
        $base = trim($slugInput ?: Str::slug($title));
        if ($base === '') $base = Str::slug(Str::random(10));

        $slug = $base;
        $i = 2;

        while (
            Post::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
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

        // Featured hanya boleh kalau published (lebih aman & rapi)
        if (!$data['is_published']) {
            $data['is_featured'] = 0;
        }

        if ($data['is_published']) {
            if (empty($data['published_at'])) {
                $data['published_at'] = now();
            } else {
                $data['published_at'] = Carbon::parse($data['published_at']);
            }
        } else {
            $data['published_at'] = null;
        }
    }

    private function handleThumbnailUpload(Request $request, ?string $currentPath): ?string
    {
        if (!$request->hasFile('thumbnail_file')) {
            return $currentPath ?: null;
        }

        // hapus file lama kalau ada
        $this->deleteThumbnailIfStored($currentPath);

        // simpan yang baru
        $path = $request->file('thumbnail_file')->store('posts', 'public');
        return $path;
    }

    private function deleteThumbnailIfStored(?string $path): void
    {
        if (!$path) return;

        // hanya delete kalau memang file lokal disk public dan berada di folder posts/
        if (Str::startsWith($path, 'posts/')) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Buat data rapi: field yang tidak relevan per type -> null
     * Jadi walau user “inject” field via request, tetap dibersihkan.
     */
    private function nullifyUnusedFieldsByType(array &$data): void
    {
        $type = $data['type'] ?? null;
        if (!$type || !isset(self::TYPE_FIELDS[$type])) return;

        $allowed = array_flip(self::TYPE_FIELDS[$type]);

        // daftar field yang mungkin ada di table
        $all = [
            'event_start_at', 'event_end_at', 'location',
            'level', 'awarded_at',
        ];

        foreach ($all as $field) {
            if (!isset($allowed[$field])) {
                $data[$field] = null;
            }
        }

        // parsing tanggal agar konsisten (opsional)
        foreach (['event_start_at','event_end_at','awarded_at'] as $dt) {
            if (!empty($data[$dt])) {
                $data[$dt] = Carbon::parse($data[$dt]);
            }
        }
    }

    // =========================================================
    // Sanitizers (minimal hardening)
    // =========================================================

    private function sanitizeText(?string $value): ?string
    {
        if ($value === null) return null;
        $value = trim($value);
        if ($value === '') return null;

        // hapus tag HTML pada excerpt text
        return strip_tags($value);
    }

    /**
     * Sanitasi longgar untuk content: buang <script> dan on* handlers.
     * Kalau nanti kamu pakai editor HTML serius, lebih baik pakai HTMLPurifier.
     */
    private function sanitizeHtmlLoose(?string $html): ?string
    {
        if ($html === null) return null;
        $html = trim($html);
        if ($html === '') return null;

        // remove script tags
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);

        // remove inline event handlers onXXX=
        $html = preg_replace('/\son\w+="[^"]*"/i', '', $html);
        $html = preg_replace("/\son\w+='[^']*'/i", '', $html);

        return $html;
    }
}
