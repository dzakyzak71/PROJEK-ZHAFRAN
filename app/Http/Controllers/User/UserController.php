<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    // Dashboard User
    public function dashboard()
    {
        // Ambil semua admin
        $admins = User::role('admin')->get();
        return view('user.pages.dashboard', compact('admins'));
    }

    // Form Edit Profil
    public function editProfil()
    {
        $user = Auth::user();
        return view('user.pages.edit-profil', compact('user'));
    }

    // Update Profil
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $path = $request->file('foto')->store('foto-profil', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}
