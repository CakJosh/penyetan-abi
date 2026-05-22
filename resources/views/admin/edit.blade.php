<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Admin Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 p-6 md:p-12">

    <div class="max-w-xl mx-auto bg-white rounded-[2rem] shadow-xl overflow-hidden">
        <div class="bg-[#3c1609] p-8 text-center">
            <h1 class="text-white text-2xl font-black tracking-widest uppercase">PENYETAN ABI</h1>
            <p class="text-orange-400 text-xs font-bold uppercase tracking-widest mt-2">Edit Menu Produk</p>
        </div>

        @if ($errors->any())
            <div class="mx-8 mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-[10px] font-bold uppercase tracking-widest">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf 
            @method('PUT') 

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Menu</label>
                <input type="text" name="nama" value="{{ old('nama', $menu->n) }}" required 
                       class="w-full border-b-2 border-gray-100 py-2 focus:outline-none focus:border-orange-500 font-bold text-gray-700 transition">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Harga (Tanpa Titik)</label>
                <input type="number" name="harga" value="{{ old('harga', $menu->h) }}" required 
                       class="w-full border-b-2 border-gray-100 py-2 focus:outline-none focus:border-orange-500 font-bold text-gray-700 transition">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pilih Kategori</label>
                <select name="kategori" required 
                        class="w-full border-b-2 border-gray-100 py-2 bg-transparent focus:outline-none focus:border-orange-500 font-bold text-gray-700 cursor-pointer">
                    <option value="Ala Carte" {{ old('kategori', $menu->category) == 'Ala Carte' || old('kategori', $menu->category) == 'ala-carte' ? 'selected' : '' }}>Ala Carte</option>
                    <option value="Paket Komplit" {{ old('kategori', $menu->category) == 'Paket Komplit' || old('kategori', $menu->category) == 'paket-komplit' ? 'selected' : '' }}>Paket Komplit</option>
                    <option value="Minuman" {{ old('kategori', $menu->category) == 'Minuman' || old('kategori', $menu->category) == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Ekstra" {{ old('kategori', $menu->category) == 'Ekstra' || old('kategori', $menu->category) == 'ekstra' ? 'selected' : '' }}>Ekstra</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Ganti Foto (Opsional)</label>
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-16 h-16 rounded-xl overflow-hidden border border-gray-100 flex items-center justify-center bg-gray-50">
                        <img src="{{ $menu->img ? asset('ASSET PENYETAN ABI/' . $menu->img) : asset('ASSET PENYETAN ABI/' . strtoupper($menu->n) . '.png') }}" 
                             class="w-full h-full object-cover" 
                             @error="$event.target.src='https://via.placeholder.com/150?text=ABI'">
                    </div>
                    <p class="text-[9px] text-gray-400 italic leading-tight">Foto saat ini. Upload file baru jika ingin mengganti gambar produk.</p>
                </div>
                <input type="file" name="foto" accept="image/*"
                    class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer transition">
            </div>

            <div class="pt-6">
                <button type="submit" 
                        class="w-full bg-orange-500 text-white py-4 rounded-2xl font-black text-lg shadow-lg hover:bg-[#3c1609] transition active:scale-95 uppercase tracking-widest">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.menu.index') }}" class="block text-center mt-4 text-[10px] font-bold text-gray-300 hover:text-gray-500 uppercase tracking-[0.2em] transition">
                    Batal & Kembali
                </a>
            </div>
        </form>
    </div>

</body>
</html>