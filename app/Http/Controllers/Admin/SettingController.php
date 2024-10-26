<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('dashboard.setting.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $setting = Setting::first();
        $logo = $setting ? $setting->logo : NULL;

        if ($request->file('logo')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $logo = $request->file('logo')->store('setting-images', 'public'); // pastikan 'public' agar dapat diakses publik
        }

        if ($setting) {
            // Update data jika setting sudah ada
            $setting->update([
                'name' => $request->name,
                'coordinate' => $request->coordinate,
                'logo' => $logo,
            ]);
        } else {
            // Buat baru jika setting belum ada
            Setting::create([
                'name' => $request->name,
                'coordinate' => $request->coordinate,
                'logo' => $logo,
            ]);
        }

        return redirect()->back()->with('success', 'Pengaturan Tersimpan');
    }
}
