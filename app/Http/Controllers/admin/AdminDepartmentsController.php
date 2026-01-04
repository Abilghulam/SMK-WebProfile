<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminDepartmentsController extends Controller
{
    public function index(Request $request)
    {
        $q = Department::query();

        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'all'); // all|active|inactive

        if ($search !== '') {
            $q->where(function ($w) use ($search) {
                $w->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $q->where('is_active', true);
        } elseif ($status === 'inactive') {
            $q->where('is_active', false);
        }

        $departments = $q->orderByDesc('is_active')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin-pages.departments.index', compact('departments', 'search', 'status'));
    }

    public function create()
    {
        $department = new Department([
            'duration_years' => 3,
            'has_internship' => true,
            'is_active' => true,
        ]);

        return view('admin-pages.departments.create', compact('department'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        // convert textarea lines -> array for json fields
        $data['competencies'] = $this->linesToArray($request->input('competencies_text'));
        $data['career_opportunities'] = $this->linesToArray($request->input('career_opportunities_text'));
        $data['learning_activities'] = $this->linesToArray($request->input('learning_activities_text'));

        // slug safety (optional): if empty, model booted() will generate from name
        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('departments', 'public');
            $data['image'] = $path; // simpan "departments/xxx.jpg"
        }

        Department::create($data);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Program keahlian berhasil ditambahkan.');
    }

    public function edit(Department $department)
    {
        return view('admin-pages.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $this->validated($request, $department);

        $data['competencies'] = $this->linesToArray($request->input('competencies_text'));
        $data['career_opportunities'] = $this->linesToArray($request->input('career_opportunities_text'));
        $data['learning_activities'] = $this->linesToArray($request->input('learning_activities_text'));

        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('departments', 'public');
            $data['image'] = $path; // simpan "departments/xxx.jpg"
        }

        $department->update($data);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Program keahlian berhasil diperbarui.');
    }

    public function toggleActive(Request $request, Department $department)
    {
        $department->is_active = !$department->is_active;
        $department->save();

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'is_active' => (bool) $department->is_active,
                'updated_at' => optional($department->updated_at)->toIso8601String(),
            ]);
        }

        return back()->with('success', 'Status program keahlian berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return back()->with('success', 'Program keahlian berhasil dihapus.');
    }

    private function validated(Request $request, ?Department $department = null): array
    {
        $id = $department?->id;

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:departments,slug,' . $id],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],

            'duration_years' => ['required', 'integer', 'min:1', 'max:10'],
            'learning_model' => ['nullable', 'string', 'max:255'],
            'graduate_profile' => ['nullable', 'string', 'max:255'],
            'has_internship' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],

            // cover image (optional)
            'image' => ['nullable', 'image', 'max:4096'], // 4MB

            // NOTE: json arrays handled via *_text -> parsed, so not validated here
        ]);
    }

    private function linesToArray(?string $text): array
    {
        $lines = preg_split("/\r\n|\n|\r/", (string) $text);
        return collect($lines)
            ->map(fn ($v) => trim($v))
            ->filter()
            ->values()
            ->all();
    }
}
