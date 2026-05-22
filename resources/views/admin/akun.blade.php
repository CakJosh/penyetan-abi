<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pengaturan Akun - Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        [x-cloak] { display: none !important; }
        .bg-figma-brown { background-color: #3c1609; }
        .animate-pop { animation: pop 0.3s ease-out forwards; }
        @keyframes pop { 0% { transform: scale(0.95); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ showSidebar: false }">

    <main class="min-h-screen pb-10">
        <header class="p-4 border-b border-gray-100 sticky top-0 bg-white/90 backdrop-blur-md z-20 flex items-center justify-between">
            <div class="flex flex-col">
                <h1 class="font-black text-gray-800 text-[10px] tracking-[0.2em] uppercase leading-none">Penyetan Abi</h1>
                <p class="text-[8px] font-bold text-orange-500 uppercase tracking-widest mt-1">Akun Admin</p>
            </div>
            
            <button @click="showSidebar = true" class="p-2 bg-gray-50 rounded-xl text-gray-600 active:scale-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <section class="p-6 max-w-xl mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-2xl animate-pop">
                    <p class="text-green-700 text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl animate-pop">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li class="text-red-700 text-[10px] font-black uppercase tracking-widest">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-gray-100 animate-pop mt-4">
                <div class="flex flex-col items-center mb-8 text-center">
                    <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center text-orange-500 mb-3 border border-orange-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21v-1a7 7 0 0114 0v1H4z" />
                        </svg>
                    </div>
                    <h2 class="text-sm font-black uppercase tracking-widest text-gray-800">Master Admin</h2>
                    <p class="text-[9px] text-gray-400 font-bold uppercase mt-1">Kelola Profil Master</p>
                </div>

                <form action="{{ url('admin/akun') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-[0.1em]">Username Baru</label>
                        <input type="text" name="username" value="{{ old('username', 'Admin') }}" required
                               class="w-full border-b-2 border-gray-50 py-2 focus:outline-none focus:border-orange-500 font-bold text-gray-700 transition">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-[0.1em]">Password Baru</label>
                        <input type="password" name="password" placeholder="Isi jika ingin ganti password" 
                               class="w-full border-b-2 border-gray-50 py-2 focus:outline-none focus:border-orange-500 font-bold text-gray-700 transition text-sm">
                        <p class="text-[9px] text-gray-400 italic mt-3">* Kosongkan jika tidak ingin mengubah password.</p>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#3c1609] text-white py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg active:scale-95 transition">
                            Update Info Akun
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </main>

    @include('admin.partials.sidebar')

</body>
</html>