<?php

namespace App\Http\Controllers\User;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

            public function dashboard()
        {
            $admins = User::role('admin')->get();
            return view('user.pages.dashboard', compact('admins'));
        }


    // Form ubah profil
    public function editProfil()
    {
        $user = Auth::user();
        return view('user.pages.components.profil-form', compact('user'));
    }

    // Update profil
        public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user->name = $request->name;

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }

            // Pastikan folder tujuan ada
            $destination = public_path('User');
            if (!file_exists($destination)) {
                mkdir($destination, 0777, true);
            }

            // Simpan file baru
            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move($destination, $filename);

            // Simpan path di database
            $user->foto = $filename;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }


    // Hapus foto profil
    public function hapusFoto()
    {
        $user = Auth::user();

        if ($user->foto) {
            $path = public_path('User/' . $user->foto);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $user->foto = null;
        $user->save();

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }
}
