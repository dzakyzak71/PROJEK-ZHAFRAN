<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AkunAdminController extends Controller
{
    public function showAdminForm()
    {
        $admins = User::role('admin')->get();
        return view('superadmin.pages.components.buat-admin', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        return redirect()->route('superadmin.buat-admin')->with('success', 'Akun admin berhasil dibuat.');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.pages.konteks.edit-admin', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $admin->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
            $admin->save();
        }

        return redirect()->route('superadmin.buat-admin')->with('success', 'Akun admin berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return redirect()->route('superadmin.buat-admin')->with('success', 'Akun admin berhasil dihapus.');
    }
}
