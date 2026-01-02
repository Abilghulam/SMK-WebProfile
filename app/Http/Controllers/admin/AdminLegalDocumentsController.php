<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminLegalDocumentsController extends Controller
{
    public function index(Request $request)
    {
        $q = LegalDocument::query();

        // filters
        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', ''));
        $status = (string) $request->query('status', ''); // published | draft | all

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

        $docs = $q->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        // dropdown kategori (simple)
        $categories = LegalDocument::query()
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('admin-pages.legal-documents.index', compact('docs', 'categories', 'search', 'category', 'status'));
    }

    public function create()
    {
        $doc = new LegalDocument([
            'category' => 'legalitas',
            'is_published' => true,
        ]);

        return view('admin-pages.legal-documents.create', compact('doc'));
    }

    public function store(Request $request)
    {
        $categories = [
            'legalitas',
            'template',
            'administrasi',
            'panduan',
        ];

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category' => ['required', Rule::in($categories)],
            'description' => ['nullable', 'string'],
            'file_path' => ['nullable', 'string', 'max:255'],
            'external_url' => ['nullable', 'url'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data = $this->validatePayload($request);

        // pastikan slug ada & unique
        $data['slug'] = $this->makeUniqueSlug($data['slug'] ?? null, $data['title']);

        // handle upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $path = $file->store('legal-documents', 'public');
            $data['file_path'] = $path;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();
        }

        $data['is_published'] = (bool) ($data['is_published'] ?? true);

        // Auto set published_at
        if ($data['is_published']) {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = null;
        }

        LegalDocument::create($data);

        return redirect()
            ->route('admin.legal-documents.index')
            ->with('success', 'Dokumen legalitas berhasil ditambahkan.');
    }

    public function edit(LegalDocument $legal_document)
    {
        $doc = $legal_document;
        return view('admin-pages.legal-documents.edit', compact('doc'));
    }

    public function update(Request $request, LegalDocument $legal_document)
    {
        $categories = [
            'legalitas',
            'template',
            'administrasi',
            'panduan',
        ];

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category' => ['required', Rule::in($categories)],
            'description' => ['nullable', 'string'],
            'file_path' => ['nullable', 'string', 'max:255'],
            'external_url' => ['nullable', 'url'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $doc = $legal_document;

        $data = $this->validatePayload($request, $doc->id);

        // slug unique (kalau kosong, turunkan dari title)
        $data['slug'] = $this->makeUniqueSlug($data['slug'] ?? null, $data['title'], $doc->id);

        // jika upload baru: hapus file lama
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            if (!empty($doc->file_path)) {
                Storage::disk('public')->delete($doc->file_path);
            }

            $path = $file->store('legal-documents', 'public');
            $data['file_path'] = $path;
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $file->getSize();

            // kalau ganti jadi upload, external url boleh dikosongin (lebih rapi)
            if (!empty($data['external_url'])) {
                // tetap izinkan user simpan external_url, tapi biasanya salah satu
                // kalau kamu mau strict XOR, uncomment baris berikut:
                $data['external_url'] = null;
            }
        }

        $data['is_published'] = (bool) ($data['is_published'] ?? false);

        if ($data['is_published']) {
            // kalau baru publish dari draft → set sekarang
            if (empty($doc->published_at)) {
                $data['published_at'] = now();
            } else {
                // tetap pakai yang lama
                $data['published_at'] = $doc->published_at;
            }
        } else {
            // jadi draft → kosongkan
            $data['published_at'] = null;
        }

        $doc->update($data);

        return redirect()
            ->route('admin.legal-documents.index')
            ->with('success', 'Dokumen legalitas berhasil diperbarui.');
    }

    public function destroy(LegalDocument $legal_document)
    {
        $doc = $legal_document;

        if (!empty($doc->file_path)) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $doc->delete();

        return redirect()
            ->route('admin.legal-documents.index')
            ->with('success', 'Dokumen legalitas berhasil dihapus.');
    }

public function togglePublish(Request $request, LegalDocument $legal_document)
{
    $legal_document->is_published = ! (bool) $legal_document->is_published;

    if ($legal_document->is_published) {
        // publish / publish ulang -> selalu update waktu sekarang
        $legal_document->published_at = now();
    } else {
        // draft -> kosongkan publikasi
        $legal_document->published_at = null;
    }

    $legal_document->save();
    $legal_document->refresh();

    if ($request->expectsJson() || $request->wantsJson()) {
        return response()->json([
            'ok' => true,
            'id' => $legal_document->id,
            'is_published' => (bool) $legal_document->is_published,
            'published_at' => optional($legal_document->published_at)->toIso8601String(),
        ]);
    }

    return back()->with('success', 'Status publikasi berhasil diperbarui.');
}


    private function validatePayload(Request $request, ?int $ignoreId = null): array
    {
        // XOR: minimal salah satu (file atau url) harus ada.
        // kalau mau benar-benar XOR (tidak boleh dua-duanya), kita enforce manual setelah validate.
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', Rule::unique('legal_documents', 'slug')->ignore($ignoreId)],
            'category'     => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'file'         => ['nullable', 'file', 'mimes:pdf', 'max:5120'], // 5MB
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $hasFile = $request->hasFile('file');
        $hasUrl = !empty($data['external_url']);

        if (!$hasFile && !$hasUrl && empty($request->input('keep_existing_file'))) {
            // untuk edit: kalau tidak upload dan tidak url, tapi file lama masih ada => boleh.
            // kita handle dengan hidden keep_existing_file dari form (lihat blade)
            // jika create, keep_existing_file tidak ada, jadi akan error.
            throw \Illuminate\Validation\ValidationException::withMessages([
                'file' => 'Upload file PDF atau isi External URL.',
            ]);
        }

        // Optional strict XOR:
        // if ($hasFile && $hasUrl) {
        //     throw \Illuminate\Validation\ValidationException::withMessages([
        //         'external_url' => 'Pilih salah satu: Upload PDF atau External URL (jangan keduanya).',
        //     ]);
        // }

        return $data;
    }

    private function makeUniqueSlug(?string $slug, string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($slug ?: $title);
        $final = $base ?: Str::random(8);

        $i = 2;
        while (
            LegalDocument::query()
                ->where('slug', $final)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $final = "{$base}-{$i}";
            $i++;
        }

        return $final;
    }
}
