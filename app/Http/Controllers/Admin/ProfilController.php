<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    // Tampilkan form profil
    public function index()
    {
        $admin = Auth::user();
        return view('admin.pages.components.profil-form', compact('admin'));
    }

    // Update profil admin
    public function update(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update nama
        $admin->name = $request->name;

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama kalau ada
            if ($admin->foto && File::exists(public_path('Admin/' . $admin->foto))) {
                File::delete(public_path('Admin/' . $admin->foto));
            }

            // Simpan foto baru
            $fotoName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('Admin'), $fotoName);
            $admin->foto = $fotoName;
        }

        $admin->save();

        return redirect()->route('admin.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    // Hapus foto profil
    public function hapusFoto()
    {
        $admin = Auth::user();

        if ($admin->foto && File::exists(public_path('Admin/' . $admin->foto))) {
            File::delete(public_path('Admin/' . $admin->foto));
        }

        $admin->foto = null;
        $admin->save();

        return redirect()->route('admin.profil')->with('success', 'Foto profil berhasil dihapus.');
    }
}
