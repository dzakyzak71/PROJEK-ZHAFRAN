<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserAdminController extends Controller
{
    public function index()
    {
        // Ambil semua user kecuali admin & superadmin
        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'user');
        })->get();

        return view('admin.pages.components.data-user', compact('users'));
    }
}
