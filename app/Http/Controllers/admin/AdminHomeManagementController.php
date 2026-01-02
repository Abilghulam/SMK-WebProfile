<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\SchoolStatistic;
use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHomeManagementController extends Controller
{
    public function index()
    {
        // pastikan selalu ada 1 record (id=1) agar tidak dobel
        $profile = SchoolProfile::query()->firstOrCreate(['id' => 1], []);
        $stats   = SchoolStatistic::query()->firstOrCreate(['id' => 1], []);
        $principal = Principal::query()->firstOrCreate(['id' => 1], []);

        return view('admin-pages.home.index', compact('profile', 'stats', 'principal'));
    }

    /* =========================
     *  SCHOOL PROFILE
     * ========================= */
    public function editProfile()
    {
        $profile = SchoolProfile::query()->firstOrCreate(['id' => 1], []);
        return view('admin-pages.home.profile-edit', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $profile = SchoolProfile::query()->firstOrCreate(['id' => 1], []);

        $data = $request->validate([
            'school_name'        => ['nullable','string','max:255'],
            'slogan'             => ['nullable','string','max:255'],
            'short_description'  => ['nullable','string','max:500'],
            'history'            => ['nullable','string'],
            'vision'             => ['nullable','string'],
            'mission'            => ['nullable','string'],
            'npsn'               => ['nullable','string','max:50'],
            'accreditation'      => ['nullable','string','max:50'],
            'curriculum'         => ['nullable','string','max:255'],
            'address'            => ['nullable','string','max:500'],
            'youtube_url'        => ['nullable','url','max:500'],
            'logo'               => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        // upload logo (opsional)
        if ($request->hasFile('logo')) {
            // hapus lama kalau ada
            if (!empty($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }
            $data['logo'] = $request->file('logo')->store('school/logo', 'public');
        }

        $profile->update($data);

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    /* =========================
     *  SCHOOL STATISTICS
     * ========================= */
    public function editStatistics()
    {
        $stats = SchoolStatistic::query()->firstOrCreate(['id' => 1], []);
        return view('admin-pages.home.statistics-edit', compact('stats'));
    }

    public function updateStatistics(Request $request)
    {
        $stats = SchoolStatistic::query()->firstOrCreate(['id' => 1], []);

        $data = $request->validate([
            'total_students'     => ['nullable','integer','min:0'],
            'total_teachers'     => ['nullable','integer','min:0'],
            'total_departments'  => ['nullable','integer','min:0'],
            'academic_year'      => ['nullable','string','max:20'],
        ]);

        $stats->update($data);

        return back()->with('success', 'Statistik sekolah berhasil diperbarui.');
    }

    /* =========================
     *  PRINCIPAL
     * ========================= */
    public function editPrincipal()
    {
        $principal = Principal::query()->firstOrCreate(['id' => 1], []);
        return view('admin-pages.home.principal-edit', compact('principal'));
    }

    public function updatePrincipal(Request $request)
    {
        $principal = Principal::query()->firstOrCreate(['id' => 1], []);

        $data = $request->validate([
            'name'            => ['nullable','string','max:255'],
            'position'        => ['nullable','string','max:255'],
            'welcome_message' => ['nullable','string'],
            'photo'           => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            if (!empty($principal->photo)) {
                Storage::disk('public')->delete($principal->photo);
            }
            $data['photo'] = $request->file('photo')->store('principal', 'public');
        }

        $principal->update($data);

        return back()->with('success', 'Data kepala sekolah berhasil diperbarui.');
    }
}
