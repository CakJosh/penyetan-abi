<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.akun');
    }

    public function update(Request $request)
    {
        // Untuk sekarang kita ambil user pertama (karena cuma ada 1 admin)
        $user = User::first(); 

        $request->validate([
            'username' => 'required',
            'password' => 'nullable|min:4',
        ]);

        $user->name = $request->username;

        // Hanya update password jika kolomnya diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}