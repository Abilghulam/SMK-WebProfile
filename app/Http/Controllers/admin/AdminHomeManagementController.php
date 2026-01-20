<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\SchoolStatistic;
use App\Models\Principal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class AdminHomeManagementController extends Controller
{
    private const SINGLETON_ID = 1;

    private function profile(): ?SchoolProfile
    {
        return SchoolProfile::query()->whereKey(self::SINGLETON_ID)->first();
    }

    private function stats(): ?SchoolStatistic
    {
        return SchoolStatistic::query()->whereKey(self::SINGLETON_ID)->first();
    }

    private function principal(): Principal
    {
        return Principal::query()->firstOrCreate(
            ['id' => self::SINGLETON_ID],
            ['position' => 'Kepala Sekolah'] // opsional, biar ada default
        );
    }

    public function index()
    {
        $profile   = $this->profile();
        $stats     = $this->stats();
        $principal = $this->principal();

        return view('admin-pages.home.index', compact('profile', 'stats', 'principal'));
    }

    public function editProfile()
    {
        $profile = $this->profile();
        return view('admin-pages.home.profile-edit', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'school_name'        => ['nullable','string','max:255'],
            'slogan'             => ['nullable','string','max:255'],
            'short_description'  => ['nullable','string','max:500'],
            'history'            => ['nullable','string'],
            'vision'             => ['nullable','string'],
            'mission'            => ['nullable','string'],
            'npsn'               => ['nullable','string','max:50'],
            'accreditation'      => ['nullable','string','max:50'],
            'curriculum'         => ['nullable','string','max:255'],
            'youtube_url'        => ['nullable','url','max:500'],
            'logo'               => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ];

        if (Schema::hasColumn('school_profiles', 'address')) {
            $rules['address'] = ['nullable','string','max:500'];
        }

        $data = $request->validate($rules);

        // ambil row id=1, kalau belum ada baru create (tapi create ini aman karena kolom sudah nullable)
        $profile = SchoolProfile::query()->firstOrCreate(['id' => self::SINGLETON_ID], []);

        if ($request->hasFile('logo') && Schema::hasColumn('school_profiles', 'logo')) {
            if (!empty($profile->logo)) {
                Storage::disk('public')->delete($profile->logo);
            }
            $data['logo'] = $request->file('logo')->store('school/logo', 'public');
        } else {
            unset($data['logo']);
        }

        $profile->update($data);

        return back()->with('success', 'Profil sekolah berhasil diperbarui.');
    }

    public function editStatistics()
    {
        $stats = $this->stats();
        return view('admin-pages.home.statistics-edit', compact('stats'));
    }

    public function updateStatistics(Request $request)
    {
        $data = $request->validate([
            'total_students'     => ['nullable','integer','min:0'],
            'total_teachers'     => ['nullable','integer','min:0'],
            'total_departments'  => ['nullable','integer','min:0'],
            'academic_year'      => ['nullable','string','max:20'],
        ]);

        $stats = SchoolStatistic::query()->firstOrCreate(['id' => self::SINGLETON_ID], []);
        $stats->update($data);

        return back()->with('success', 'Statistik sekolah berhasil diperbarui.');
    }

    public function editPrincipal()
    {
        $principal = $this->principal();
        return view('admin-pages.home.principal-edit', compact('principal'));
    }

    public function updatePrincipal(Request $request)
    {
        $data = $request->validate([
            'name'            => ['nullable','string','max:255'],
            'position'        => ['nullable','string','max:255'],
            'welcome_message' => ['nullable','string'],
            'photo'           => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        $principal = Principal::query()->firstOrCreate(['id' => self::SINGLETON_ID], []);

        if ($request->hasFile('photo') && Schema::hasColumn('principals', 'photo')) {
            if (!empty($principal->photo)) {
                Storage::disk('public')->delete($principal->photo);
            }
            $data['photo'] = $request->file('photo')->store('principal', 'public');
        } else {
            unset($data['photo']);
        }

        $principal->update($data);

        return back()->with('success', 'Data kepala sekolah berhasil diperbarui.');
    }
}
