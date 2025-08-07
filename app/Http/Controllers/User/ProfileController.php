<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('user.components.profile');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->name;

        if ($request->hasFile('foto')) {
            // hapus foto lama
            if ($user->foto && Storage::disk('public')->exists('foto/' . $user->foto)) {
                Storage::disk('public')->delete('foto/' . $user->foto);
            }

            $fotoName = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('foto', $fotoName, 'public');
            $user->foto = $fotoName;
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profil berhasil diperbarui.');
    }
}
