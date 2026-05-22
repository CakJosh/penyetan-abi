<div x-show="showSidebar" x-cloak @click="showSidebar = false" 
     class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[40]"></div>

<div x-show="showSidebar" x-cloak 
     x-transition:enter="transition transform duration-300" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
     x-transition:leave="transition transform duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
     class="fixed top-0 right-0 h-full w-72 bg-[#3c1609] z-[50] shadow-2xl p-8 text-white text-left">
    
    <div class="flex justify-between items-center mb-12">
        <div class="flex flex-col">
            <span class="text-[10px] font-bold text-orange-400 uppercase tracking-[0.2em]">Manajemen</span>
            <h2 class="font-black text-lg tracking-widest uppercase">Penyetan Abi</h2>
        </div>
        <button @click="showSidebar = false" class="text-white/30 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="space-y-8">
        <a href="/admin/dashboard" class="flex items-center gap-5 transition group {{ request()->is('admin/dashboard') ? 'text-orange-400' : 'text-white/70 hover:text-white' }}">
            <div class="p-3 rounded-2xl {{ request()->is('admin/dashboard') ? 'bg-white/10' : 'bg-white/5' }} group-hover:bg-orange-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
            </div>
            <span class="text-xs font-black uppercase tracking-widest">Antrian</span>
        </a>

        <a href="/admin/laporan" class="flex items-center gap-5 transition group {{ request()->is('admin/laporan') ? 'text-orange-400' : 'text-white/70 hover:text-white' }}">
            <div class="p-3 rounded-2xl {{ request()->is('admin/laporan') ? 'bg-white/10' : 'bg-white/5' }} group-hover:bg-orange-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
            </div>
            <span class="text-xs font-black uppercase tracking-widest">Laporan</span>
        </a>

        <a href="/admin/menu" class="flex items-center gap-5 transition group {{ request()->is('admin/menu*') ? 'text-orange-400' : 'text-white/70 hover:text-white' }}">
            <div class="p-3 rounded-2xl {{ request()->is('admin/menu*') ? 'bg-white/10' : 'bg-white/5' }} group-hover:bg-orange-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
            </div>
            <span class="text-xs font-black uppercase tracking-widest">Atur Menu</span>
        </a>

        <a href="/admin/akun" class="flex items-center gap-5 transition group {{ request()->is('admin/akun*') ? 'text-orange-400' : 'text-white/70 hover:text-white' }}">
            <div class="p-3 rounded-2xl {{ request()->is('admin/akun*') ? 'bg-white/10' : 'bg-white/5' }} group-hover:bg-orange-500 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM4 21v-1a7 7 0 0114 0v1H4z" /></svg>
            </div>
            <span class="text-xs font-black uppercase tracking-widest">Akun Admin</span>
        </a>
    </nav>

    {{-- LOGIKA BARU: Jika halaman saat ini BUKAN dashboard, BUKAN laporan, dan BUKAN menu, tampilkan logout --}}
    @if (!request()->is('admin/dashboard*') && !request()->is('admin/laporan*') && !request()->is('admin/menu*'))
        <div class="mt-20 pt-8 border-t border-white/10">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-5 text-red-400 hover:text-red-300 transition uppercase text-[10px] font-black tracking-widest w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3 3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                    LogOut
                </button>
            </form>
        </div>
    @endif
</div>