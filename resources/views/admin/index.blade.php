<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Menu - Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        [x-cloak] { display: none !important; }
        .bg-figma-brown { background-color: #3c1609; }
        .animate-pop { animation: pop 0.3s ease-out forwards; }
        @keyframes pop { 0% { transform: scale(0.95); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body class="bg-white text-gray-800" x-data="{ showSidebar: false, ...menuManager() }">

    @verbatim
    <main class="min-h-screen pb-24">
        <header class="p-4 border-b border-gray-100 sticky top-0 bg-white/90 backdrop-blur-md z-30 flex items-center justify-between">
            <div class="flex flex-col">
                <h1 class="font-black text-gray-800 text-[10px] tracking-[0.2em] uppercase leading-none">Penyetan Abi</h1>
                <p class="text-[8px] font-bold text-orange-500 uppercase tracking-widest mt-1">Manajemen Menu</p>
            </div>
            
            <button @click="showSidebar = true" class="p-2 bg-gray-50 rounded-xl text-gray-600 active:scale-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <div class="p-6 max-w-xl mx-auto">
            <div class="flex justify-start mb-8">
                <a href="/admin/menu/create" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-orange-100 active:scale-95 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Menu
                </a>
            </div>

            <div class="space-y-4">
                <template x-for="(item, index) in menuList" :key="index">
                    <div class="bg-white border border-gray-100 rounded-[2.5rem] p-4 flex items-center justify-between shadow-sm animate-pop">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 bg-gray-50 rounded-full overflow-hidden border border-gray-100 flex-shrink-0 flex items-center justify-center">
                                <img :src="'/ASSET PENYETAN ABI/' + item.nama.toUpperCase() + '.png'" 
                                     loading="lazy"
                                     class="w-full h-full object-cover" 
                                     @error="$event.target.src='https://via.placeholder.com/150?text=ABI'">
                            </div>
                            <div>
                                <h3 class="font-black text-sm text-gray-800 uppercase tracking-tight" x-text="item.nama"></h3>
                                <div class="flex gap-2 items-center mt-0.5">
                                    <span class="text-[9px] font-black text-orange-500 uppercase tracking-widest" x-text="item.kategori"></span>
                                    <span class="text-gray-200 text-[10px]">|</span>
                                    <span class="text-[10px] font-bold text-gray-400" x-text="'Rp ' + item.harga.toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a :href="'/admin/menu/' + item.id + '/edit'" class="w-10 h-10 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition hover:bg-orange-50 hover:text-orange-500 active:scale-90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            
                            <button @click="deleteItem(item.id)" class="w-10 h-10 bg-gray-50 text-gray-400 rounded-xl flex items-center justify-center transition hover:bg-red-50 hover:text-red-500 active:scale-90">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </main>
    @endverbatim

    {{-- MEMANGGIL SIDEBAR PARTIALS --}}
    @include('admin.partials.sidebar')

    <script>
        function menuManager() {
            return {
                // DATA LIST MENU BERHASIL DIKEMBALIKAN UTUH
                // Agar tidak memicu Error 404, pastikan ID di bawah ini mewakili baris ID data nyata yang ada di phpMyAdmin kamu!
                menuList: [
                    { id: 1, nama: 'Lele Goreng', kategori: 'Ala Carte', harga: 15000 },
                    { id: 2, nama: 'Paket Komplit A', kategori: 'Paket Komplit', harga: 25000 },
                    { id: 3, nama: 'Es Teh Manis', kategori: 'Minuman', harga: 5000 },
                    { id: 4, nama: 'Nasi Putih', kategori: 'Ekstra', harga: 5000 },
                ],
                deleteItem(id) {
                    if(confirm('Hapus menu ini secara permanen?')) {
                        this.menuList = this.menuList.filter(item => item.id !== id);
                    }
                }
            }
        }
    </script>
</body>
</html>