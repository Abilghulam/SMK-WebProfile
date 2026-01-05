<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSettingsController extends Controller
{
    private function getSingleton(): Setting
    {
        // single record (kalau belum ada, dibuat)
        return Setting::query()->firstOrCreate([]);
    }

    public function index()
    {
        $settings = $this->getSingleton();

        return view('admin-pages.settings.index', [
            'settings' => $settings,
        ]);
    }

    public function school()
    {
        $settings = $this->getSingleton();

        return view('admin-pages.settings.school', [
            'settings' => $settings,
        ]);
    }

    public function updateSchool(Request $request)
    {
        $settings = $this->getSingleton();

        $data = $request->validate([
            'site_name'       => ['nullable', 'string', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'email'           => ['nullable', 'string', 'max:100'],
            'instagram_url'   => ['nullable', 'string', 'max:255'],
            'facebook_url'    => ['nullable', 'string', 'max:255'],
            'tiktok_url'      => ['nullable', 'string', 'max:255'],
            'whatsapp_url'    => ['nullable', 'string', 'max:255'],
            'address'         => ['nullable', 'string'],
            'maps_embed'      => ['nullable', 'string'],
            'footer_about'    => ['nullable', 'string'],
            'copyright_text'  => ['nullable', 'string', 'max:255'],

            // upload
            'logo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'favicon'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,ico', 'max:1024'],
        ]);

        // handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeAndReplaceFile(
                $request->file('logo'),
                $settings->logo,
                'settings'
            );
        }

        // handle favicon upload
        if ($request->hasFile('favicon')) {
            $data['favicon'] = $this->storeAndReplaceFile(
                $request->file('favicon'),
                $settings->favicon,
                'settings'
            );
        }

        $settings->update($data);

        return back()->with('success', 'Informasi sekolah berhasil diperbarui.');
    }

    private function storeAndReplaceFile($file, ?string $oldPath, string $dir): string
    {
        // simpan ke storage/app/public/{dir}
        $stored = $file->store($dir, 'public'); // contoh: settings/abc.webp

        // db disimpan sesuai pola yang kamu pakai di sidebar: asset($settings->logo)
        // => simpan "storage/..." supaya langsung valid
        $newPath = 'storage/' . $stored;

        // hapus file lama kalau ada
        if (!empty($oldPath)) {
            $old = str_starts_with($oldPath, 'storage/') ? substr($oldPath, 8) : $oldPath;
            if (!empty($old) && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }

        return $newPath;
    }
}
