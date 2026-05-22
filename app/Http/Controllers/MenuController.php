<?php

namespace App\Http\Controllers;

use App\Models\Menu; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; 

class MenuController extends Controller
{
    /**
     * Menampilkan daftar menu (untuk Admin)
     */
    public function index()
    {
        /** @var \App\Models\Menu $menus */
        $menus = Menu::all(); 
        return view('admin.index', compact('menus'));
    }

    /**
     * Menampilkan form untuk tambah menu baru
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Menyimpan data menu baru ke database
     */
    public function store(Request $request)
    {
        // PERBAIKAN: Menyesuaikan key validation dengan atribut name deskriptif di file create.blade.php
        $request->validate([
            'nama'     => 'required|max:255',
            'harga'    => 'required|numeric', 
            'kategori' => 'required',
            'foto'     => 'required|image|mimes:jpeg,png,jpg|max:2048', 
        ], [
            'foto.max'      => 'Waduh, gambarnya kegedean! Maksimal cuma boleh 2MB ya.',
            'foto.mimes'    => 'Format gambar harus JPEG, PNG, atau JPG.',
            'foto.required' => 'Jangan lupa upload foto makanannya ya!'
        ]);

        $nama_gambar = null;

        // PERBAIKAN: Menyesuaikan pemanggilan file upload dengan name="foto"
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_gambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('ASSET PENYETAN ABI'), $nama_gambar);
        }

        // PERBAIKAN: Memetakan request data panjang ke dalam kolom database asli (n, h, img, category)
        Menu::create([
            'n'        => $request->nama,
            'h'        => $request->harga,
            'img'      => $nama_gambar, 
            'category' => $request->kategori,
        ]);

        return redirect('/admin/menu')->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan halaman edit
     */
    public function edit($id)
    {
        /** @var \App\Models\Menu $menu */
        $menu = Menu::findOrFail($id); 
        return view('admin.edit', compact('menu'));
    }

    /**
     * Memperbarui data menu
     */
    public function update(Request $request, $id)
    {
        /** @var \App\Models\Menu $menu */
        $menu = Menu::findOrFail($id);

        // PERBAIKAN: Menyesuaikan key validation dengan name panjang deskriptif dari form edit.blade.php
        $request->validate([
            'nama'     => 'required|max:255',
            'harga'    => 'required|numeric',
            'kategori' => 'required',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $nama_gambar = $menu->img;

        // PERBAIKAN: Menyesuaikan pemanggilan file update gambar dengan name="foto"
        if ($request->hasFile('foto')) {
            // Hapus gambar lama jika ada file baru yang diupload
            if ($menu->img && File::exists(public_path('ASSET PENYETAN ABI/' . $menu->img))) {
                File::delete(public_path('ASSET PENYETAN ABI/' . $menu->img));
            }

            $file = $request->file('foto');
            $nama_gambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('ASSET PENYETAN ABI'), $nama_gambar);
        }

        // PERBAIKAN: Mengupdate data kolom asli database dengan data input panjang dari form edit
        $menu->update([
            'n'        => $request->nama,
            'h'        => $request->harga,
            'category' => $request->kategori,
            'img'      => $nama_gambar 
        ]);

        return redirect('/admin/menu')->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Menghapus menu
     */
    public function destroy($id)
    {
        /** @var \App\Models\Menu $menu */
        $menu = Menu::findOrFail($id);
        
        if ($menu->img && File::exists(public_path('ASSET PENYETAN ABI/' . $menu->img))) {
            File::delete(public_path('ASSET PENYETAN ABI/' . $menu->img));
        }
        
        $menu->delete();

        return redirect('/admin/menu')->with('success', 'Menu berhasil dihapus!');
    }
}