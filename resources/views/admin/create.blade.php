<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Admin Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 p-6 md:p-12">

    <div class="max-w-xl mx-auto bg-white rounded-[2rem] shadow-xl overflow-hidden">
        <div class="bg-[#3c1609] p-8 text-center">
            <h1 class="text-white text-2xl font-black tracking-widest uppercase">PENYETAN ABI</h1>
            <p class="text-orange-400 text-xs font-bold uppercase tracking-widest mt-2">Tambah Menu Baru</p>
        </div>

        {{-- BOX VALIDASI ERROR --}}
        @if ($errors->any())
            <div class="mx-8 mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-700 text-[10px] font-bold uppercase tracking-widest">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM PENAMBAHAN DATA MENU --}}
        <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf 

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Menu</label>
                {{-- PERBAIKAN: Mengubah name="n" menjadi name="nama" agar sinkron dengan database & controller --}}
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Lele Goreng" 
                       class="w-full border-b-2 border-gray-100 py-2 focus:outline-none focus:border-orange-500 font-bold text-gray-700 transition">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Harga (Tanpa Titik)</label>
                {{-- PERBAIKAN: Mengubah name="h" menjadi name="harga" agar sinkron dengan database & controller --}}
                <input type="number" name="harga" value="{{ old('harga') }}" required placeholder="Contoh: 15000" 
                       class="w-full border-b-2 border-gray-100 py-2 focus:outline-none focus:border-orange-500 font-bold text-gray-700 transition">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pilih Kategori</label>
                {{-- PERBAIKAN: Mengubah name="category" menjadi name="kategori" agar sesuai dengan pemanggilan data AlpineJS --}}
                <select name="kategori" required 
                        class="w-full border-b-2 border-gray-100 py-2 bg-transparent focus:outline-none focus:border-orange-500 font-bold text-gray-700 cursor-pointer">
                    <option value="Ala Carte" {{ old('kategori') == 'Ala Carte' ? 'selected' : '' }}>Ala Carte</option>
                    <option value="Paket Komplit" {{ old('kategori') == 'Paket Komplit' ? 'selected' : '' }}>Paket Komplit</option>
                    <option value="Minuman" {{ old('kategori') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Ekstra" {{ old('kategori') == 'Ekstra' ? 'selected' : '' }}>Ekstra</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Foto Makanan</label>
                {{-- PERBAIKAN: Memastikan name="foto" deskriptif untuk penanganan upload file --}}
                <input type="file" name="foto" accept="image/*" required
                    class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer transition">
                <p class="mt-2 text-[9px] text-gray-400 italic font-medium tracking-wider">* Maksimal ukuran file 2MB agar loading menu user cepat.</p>
            </div>

            <div class="pt-6">
                <button type="submit" 
                        class="w-full bg-orange-500 text-white py-4 rounded-2xl font-black text-lg shadow-lg hover:bg-[#3c1609] transition active:scale-95 uppercase tracking-widest">
                    Simpan Menu
                </button>
                
                {{-- PERBAIKAN: Mengubah hardcode link menjadi route bawaan admin agar seragam --}}
                <a href="{{ route('admin.menu.index') }}" class="block text-center mt-4 text-[10px] font-bold text-gray-300 hover:text-gray-500 uppercase tracking-[0.2em] transition">
                    Batal & Kembali
                </a>
            </div>
        </form>
    </div>

</body>
</html>