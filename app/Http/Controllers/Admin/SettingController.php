<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();

        if (!$settings) {
            $settings = Setting::create([
                'nama_website' => 'LensCamp',
                'email_admin' => 'admin.lenscamp@gmail.com',
                'no_whatsapp' => '081291516627',
                'alamat' => 'Batam, Indonesia',
            ]);
        }

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_website' => 'required|string|max:100',
            'email_admin' => 'required|email|max:100',
            'no_whatsapp' => 'required|string|max:30',
            'alamat' => 'required|string',
        ]);

        $settings = Setting::first();

        if (!$settings) {
            $settings = Setting::create([
                'nama_website' => 'LensCamp',
                'email_admin' => 'admin.lenscamp@gmail.com',
                'no_whatsapp' => '081291516627',
                'alamat' => 'Batam, Indonesia',
            ]);
        }

        $settings->update([
            'nama_website' => $request->nama_website,
            'email_admin' => $request->email_admin,
            'no_whatsapp' => $request->no_whatsapp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}