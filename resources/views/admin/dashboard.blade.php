<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Dashboard - Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=200;300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        [x-cloak] { display: none !important; }
        .bg-figma-green { background-color: #b3a125; }
        .text-figma-brown { color: #3c1609; }
        @keyframes pop { 0% { transform: scale(0.95); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .animate-pop { animation: pop 0.3s ease-out forwards; }
    </style>
</head>
<body class="bg-white" x-data="{ showSidebar: false, ...dashboardAdmin() }" x-init="init()">

    <main class="min-h-screen pb-10">
        <header class="p-4 border-b border-gray-100 flex justify-between items-center sticky top-0 bg-white/90 backdrop-blur-md z-20">
            <div class="flex flex-col">
                <h1 class="font-black text-gray-800 text-[10px] tracking-[0.2em] uppercase">Penyetan Abi</h1>
                <p class="text-[8px] font-bold text-orange-500 uppercase tracking-widest mt-1">Antrian Pesanan</p>
            </div>

            <button @click="showSidebar = true" class="p-2 bg-gray-50 rounded-xl text-gray-600 active:scale-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </header>

        <div class="p-4 max-w-md mx-auto">
            <div class="flex w-full bg-gray-100 rounded-2xl p-1 gap-1">
                <button @click="activeTab = 'pesanan'" :class="activeTab === 'pesanan' ? 'bg-figma-green text-figma-brown shadow-sm' : 'text-gray-400'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase flex items-center justify-center gap-2 transition-all">
                    <span>Pesanan</span>
                    <span x-show="jumlahProses > 0" class="bg-orange-500 text-white text-[8px] px-1.5 py-0.5 rounded-full" x-text="jumlahProses"></span>
                </button>
                <button @click="activeTab = 'selesai'" :class="activeTab === 'selesai' ? 'bg-figma-green text-figma-brown shadow-sm' : 'text-gray-400'" class="flex-1 py-3 rounded-xl text-[10px] font-black uppercase flex items-center justify-center gap-2 transition-all">
                    <span>Selesai</span>
                    <span x-show="jumlahSelesai > 0" class="bg-[#3c1609] text-white text-[8px] px-1.5 py-0.5 rounded-full" x-text="jumlahSelesai"></span>
                </button>
            </div>
        </div>

        <div class="max-w-xl mx-auto p-6">
            <template x-if="activeTab === 'pesanan'">
                <div class="space-y-6">
                    <template x-for="order in orders.filter(o => o.status === 'proses')" :key="order.id">
                        <div class="p-5 rounded-[2.5rem] border border-gray-100 bg-orange-50/30 shadow-sm relative overflow-hidden animate-pop">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <p class="text-[8px] font-black text-gray-300 uppercase tracking-widest mb-0.5">No. Antrian</p>
                                    <h3 class="text-5xl font-light text-gray-900 leading-none -ml-1" x-text="order.no"></h3>
                                </div>
                                <div class="flex flex-col items-end gap-1.5">
                                    <p class="text-[9px] font-black bg-figma-green px-2.5 py-1 rounded-full text-figma-brown uppercase" x-text="order.tipe"></p>
                                    <p class="text-[10px] font-black text-gray-400 uppercase" x-text="order.waktu + ' WIB'"></p>
                                </div>
                            </div>
                            <h4 class="text-lg font-black text-[#3c1609] uppercase mb-3" x-text="order.nama"></h4>
                            <p class="text-[11px] text-gray-700 font-bold" x-text="order.menu"></p>
                            <div class="bg-white/80 p-3 rounded-xl border border-orange-100/50 my-4 text-[10px] text-gray-600 italic" x-text="order.catatan || '-'"></div>
                            <button @click="selesaikanPesanan(order)" class="w-full bg-[#3c1609] text-white py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-md active:scale-95 transition">Selesaikan Pesanan</button>
                        </div>
                    </template>
                    <template x-if="jumlahProses === 0">
                        <div class="text-center py-20 opacity-30 text-xs font-black uppercase tracking-widest">Tidak ada antrian aktif</div>
                    </template>
                </div>
            </template>
            
            <template x-if="activeTab === 'selesai'">
                <div class="space-y-2"> 
                    <template x-for="order in orders.filter(o => o.status === 'selesai')" :key="order.id">
                        <div @click="openReceipt(order)" class="px-5 py-4 rounded-[1.5rem] border border-gray-100 bg-white shadow-sm animate-pop cursor-pointer active:bg-gray-50 transition">
                            <div class="flex justify-between items-center mb-1">
                                <p class="text-xl font-light text-gray-900" x-text="order.no"></p>
                                <p class="text-[9px] font-black text-gray-400 uppercase" x-text="order.waktu + ' WIB'"></p>
                            </div>
                            <div class="flex justify-between items-center">
                                <h4 class="text-[13px] font-black text-[#3c1609] uppercase tracking-tight" x-text="order.nama"></h4>
                                <span class="text-[11px] font-black text-orange-600" x-text="'Rp ' + order.total.toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </main>

    {{-- MEMANGGIL SIDEBAR DARI FOLDER PARTIALS --}}
    @include('admin.partials.sidebar')

    <script>
        function dashboardAdmin() {
            return {
                activeTab: 'pesanan',
                showReceipt: false,
                selectedOrder: null,
                orders: [],
                init() {
                    const savedOrders = localStorage.getItem('abi_admin_orders');
                    const lastDate = localStorage.getItem('abi_admin_last_date');
                    const today = new Date().toLocaleDateString('en-CA');
                    const displayDate = new Date().toLocaleDateString('id-ID');

                    if (lastDate && lastDate !== today) {
                        this.orders = [];
                        localStorage.setItem('abi_admin_orders', JSON.stringify([]));
                    } else {
                        this.orders = savedOrders ? JSON.parse(savedOrders) : [
                            { 
                                id: 1, no: '001', nama: 'JOSHUA', hp: '0812-3456-7890', 
                                waktu: '10:45', tanggal: today, tanggalDisplay: displayDate,
                                menu: '1x Lele Goreng, 1x Nasi Putih', catatan: 'Sambal dipisah', 
                                total: 20000, status: 'proses', tipe: 'Dine In',
                                items: [
                                    { nama: 'Lele Goreng', qty: 1, harga: 15000 },
                                    { nama: 'Nasi Putih', qty: 1, harga: 5000 }
                                ]
                            }
                        ];
                    }
                    localStorage.setItem('abi_admin_last_date', today);
                    this.$watch('orders', (val) => localStorage.setItem('abi_admin_orders', JSON.stringify(val)));
                },
                selesaikanPesanan(order) {
                    if(confirm('Selesaikan pesanan?')) { order.status = 'selesai'; }
                },
                openReceipt(order) {
                    this.selectedOrder = order;
                    this.showReceipt = true;
                },
                get jumlahSelesai() { return this.orders.filter(o => o.status === 'selesai').length; },
                get jumlahProses() { return this.orders.filter(o => o.status === 'proses').length; }
            }
        }
    </script>
</body>
</html>