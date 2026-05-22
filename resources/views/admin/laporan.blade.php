<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Laporan - Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=200;300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        [x-cloak] { display: none !important; }
        .bg-figma-brown { background-color: #3c1609; }
        @keyframes pop { 0% { transform: scale(0.95); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .animate-pop { animation: pop 0.3s ease-out forwards; }
    </style>
</head>
<body class="bg-white" x-data="{ showSidebar: false, ...laporanSystem() }">

    @verbatim
    <main class="min-h-screen pb-10">
        <header class="p-4 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white/90 backdrop-blur-md z-20">
            <div class="flex flex-col">
                <h1 class="font-black text-gray-800 text-[10px] tracking-[0.2em] uppercase">Penyetan Abi</h1>
                <p class="text-[8px] font-bold text-orange-500 uppercase tracking-widest mt-1">Laporan Penjualan</p>
            </div>

            <button @click="showSidebar = true" class="p-2 bg-gray-50 rounded-xl text-gray-600 active:scale-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <div class="max-w-xl mx-auto p-6">
            <div class="relative mb-8">
                <label class="absolute -top-2 left-3 bg-white px-1 text-[10px] text-gray-400 font-bold uppercase tracking-widest z-10" x-text="filterMode === 'harian' ? 'Pilih Tanggal' : 'Filter Aktif'"></label>
                <div class="flex items-center border-2 border-gray-200 rounded-2xl overflow-hidden focus-within:border-orange-500 transition-all bg-white shadow-sm">
                    <input type="text" :value="displayLabel" readonly class="w-full p-4 outline-none text-gray-700 font-bold tracking-widest text-sm cursor-default">
                    <button @click="showCalendar = !showCalendar" class="p-4 bg-gray-50 border-l border-gray-100 text-gray-500 hover:text-orange-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>

                <div x-show="showCalendar" x-cloak @click.away="showCalendar = false" class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-100 shadow-2xl rounded-[2rem] p-6 z-30 animate-pop">
                    <div class="flex justify-between items-center mb-6">
                        <button @click="prevMonth()" class="p-2 text-gray-400 hover:text-orange-500">&lt;</button>
                        <div class="flex gap-2 font-black text-gray-800 uppercase text-xs">
                            <span x-text="months[selectedMonthIndex]"></span>
                            <select x-model.number="selectedYear" @change="updateDisplayLabel()" class="bg-transparent outline-none cursor-pointer text-orange-600">
                                <template x-for="year in Array.from({length: 5}, (_, i) => 2026 + i)" :key="year">
                                    <option :value="year" x-text="year"></option>
                                </template>
                            </select>
                        </div>
                        <button @click="nextMonth()" class="p-2 text-gray-400 hover:text-orange-500">&gt;</button>
                    </div>
                    
                    <div class="grid grid-cols-7 text-center text-[10px] font-black text-gray-300 mb-4">
                        <template x-for="day in ['SU','MO','TU','WE','TH','FR','SA']"> <span x-text="day"></span> </template>
                    </div>
                    <div class="grid grid-cols-7 gap-1 mb-6 border-b pb-6">
                        <template x-for="item in daysInMonth()">
                            <button @click="pickDate(item.day)" 
                                    :disabled="!item.current"
                                    :class="isSelected(item.day) ? 'bg-orange-500 text-white rounded-lg shadow-md' : 'text-gray-600'"
                                    class="py-3 text-xs font-bold transition" x-text="item.day"></button>
                        </template>
                    </div>

                    <div class="grid grid-cols-3 gap-3 pt-2">
                        <button @click="setFilter('minggu')" :class="filterMode === 'minggu' ? 'bg-[#3c1609] text-white shadow-lg scale-95' : 'bg-gray-50 text-gray-400'" class="py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">1 Minggu</button>
                        <button @click="setFilter('bulan')" :class="filterMode === 'bulan' ? 'bg-[#3c1609] text-white shadow-lg scale-95' : 'bg-gray-50 text-gray-400'" class="py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">1 Bulan</button>
                        <button @click="setFilter('tahun')" :class="filterMode === 'tahun' ? 'bg-[#3c1609] text-white shadow-lg scale-95' : 'bg-gray-50 text-gray-400'" class="py-3 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all">1 Tahun</button>
                    </div>
                </div>
            </div>

            <div x-show="orders.length === 0" x-cloak class="flex flex-col items-center justify-center py-24 text-center animate-pop opacity-20">
                <div class="text-[120px] font-light text-gray-400 select-none tracking-tighter mb-4">:(</div>
                <p class="font-bold text-sm text-gray-500 uppercase tracking-[0.2em]">Tidak ada data pada periode ini</p>
            </div>

            <div x-show="orders.length > 0" class="animate-pop">
                <h3 class="font-black text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-6 text-center">Rekap Terjual (<span x-text="displayLabel"></span>)</h3>
                <div class="bg-white border border-gray-100 rounded-[2.5rem] overflow-hidden shadow-sm">
                    <template x-for="(item, index) in orders" :key="index">
                        <div class="flex items-center justify-between p-5 border-b border-gray-50 last:border-0 hover:bg-gray-50 transition">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center border border-gray-100 overflow-hidden shrink-0">
                                    <img :src="'/ASSET PENYETAN ABI/' + item.nama.toUpperCase() + '.png'" 
                                         loading="lazy"
                                         class="w-full h-full object-cover" 
                                         @error="$event.target.src='https://via.placeholder.com/150?text=ABI'">
                                </div>
                                <span class="font-bold text-sm uppercase text-gray-800 tracking-tight" x-text="item.nama"></span>
                            </div>
                            <span class="text-xs font-black text-gray-400 bg-gray-50 px-3 py-1 rounded-full" x-text="item.qty + ' pcs'"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </main>
    @endverbatim

    {{-- MEMANGGIL SIDEBAR PARTIALS YANG PINTAR --}}
    @include('admin.partials.sidebar')

    <script>
        function laporanSystem() {
            const now = new Date();
            return {
                showCalendar: false,
                filterMode: 'harian',
                displayLabel: '',
                selectedDay: now.getDate(),
                selectedMonthIndex: now.getMonth(),
                selectedYear: 2026,
                months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                orders: [],
                
                init() {
                    this.updateDisplayLabel();
                    this.orders = [
                        { nama: 'LELE GORENG', qty: 5 },
                        { nama: 'AYAM GORENG', qty: 3 }
                    ];
                },
                daysInMonth() {
                    let firstDay = new Date(this.selectedYear, this.selectedMonthIndex, 1).getDay();
                    let daysCount = new Date(this.selectedYear, this.selectedMonthIndex + 1, 0).getDate();
                    let days = [];
                    for (let i = 0; i < firstDay; i++) days.push({ day: '', current: false });
                    for (let i = 1; i <= daysCount; i++) days.push({ day: i, current: true });
                    return days;
                },
                isSelected(day) { return day === this.selectedDay && this.filterMode === 'harian'; },
                pickDate(day) {
                    if(!day) return;
                    this.selectedDay = day;
                    this.filterMode = 'harian';
                    this.updateDisplayLabel();
                    this.showCalendar = false;
                },
                setFilter(mode) {
                    this.filterMode = mode;
                    this.updateDisplayLabel();
                    this.showCalendar = false;
                },
                updateDisplayLabel() {
                    if(this.filterMode === 'harian') {
                        const dd = String(this.selectedDay).padStart(2, '0');
                        const mm = String(this.selectedMonthIndex + 1).padStart(2, '0');
                        this.displayLabel = dd + ' / ' + mm + ' / ' + this.selectedYear;
                    } else {
                        const cap = this.filterMode.charAt(0).toUpperCase() + this.filterMode.slice(1);
                        this.displayLabel = 'Rekap 1 ' + cap;
                    }
                },
                prevMonth() { if (this.selectedMonthIndex === 0) { this.selectedMonthIndex = 11; this.selectedYear--; } else this.selectedMonthIndex--; },
                nextMonth() { if (this.selectedMonthIndex === 11) { this.selectedMonthIndex = 0; this.selectedYear++; } else this.selectedMonthIndex++; }
            }
        }
    </script>
</body>
</html>