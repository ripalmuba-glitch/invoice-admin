<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan form pengaturan.
     * Kita gunakan 'firstOrCreate' agar baris data (id=1) selalu ada.
     */
    public function index()
    {
        // Ambil data pengaturan (atau buat baru jika belum ada)
        $settings = Setting::firstOrCreate(['id' => 1]);

        return view('settings.index', compact('settings'));
    }

    /**
     * Menyimpan/Memperbarui data pengaturan.
     */
    public function update(Request $request)
    {
        $settings = Setting::find(1);

        // Validasi
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string',
            'company_city_state_zip' => 'nullable|string',
            'company_phone' => 'nullable|string',
            'company_email' => 'nullable|email',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi Logo
            'default_notes' => 'nullable|string',
        ]);

        // 1. Handle Upload Logo
        if ($request->hasFile('company_logo')) {
            // Hapus logo lama jika ada
            if ($settings->company_logo) {
                Storage::disk('public')->delete($settings->company_logo);
            }

            // Simpan logo baru di 'storage/app/public/logos'
            // dan simpan path-nya (misal: 'logos/namafile.png')
            $path = $request->file('company_logo')->store('logos', 'public');
            $validated['company_logo'] = $path;
        }

        // 2. Update data di database
        $settings->update($validated);

        return redirect()
            ->route('settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
