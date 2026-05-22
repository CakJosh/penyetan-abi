<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        @media print {
            body * { visibility: hidden; }
            #receipt-content, #receipt-content * { visibility: visible; }
            #receipt-content { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-white" x-data="{ 
    cartItems: JSON.parse(localStorage.getItem('abi_cart') || '[]'),
    showForm: false,
    showReceipt: false,
    lastOrder: null,
    orderType: 'Makan Di Tempat',
    formData: { nama: '', telepon: '', catatan: '' },
    
    updateStorage() {
        localStorage.setItem('abi_cart', JSON.stringify(this.cartItems));
    },

    addQty(index) {
        this.cartItems[index].qty++;
        this.updateStorage();
    },

    minusQty(index) {
        if(this.cartItems[index].qty > 1) {
            this.cartItems[index].qty--;
            this.updateStorage();
        }
    },

    removeItem(index) {
        this.cartItems.splice(index, 1);
        this.updateStorage();
    },

    calculateTotal() {
        return this.cartItems.reduce((total, item) => {
            let price = parseInt(item.h.replace('.', ''));
            return total + (price * item.qty);
        }, 0);
    },

    getNextQueue() {
        const today = new Date().toLocaleDateString('en-CA');
        let lastOrderData = JSON.parse(localStorage.getItem('abi_last_queue') || '{}');
        let nextNum = 1;
        if (lastOrderData.date === today) {
            nextNum = lastOrderData.number + 1;
        }
        return String(nextNum).padStart(3, '0');
    },

    submitOrder() {
        if(!this.formData.nama || !this.formData.telepon) {
            alert('Mohon lengkapi Nama dan No. Telepon ya!');
            return;
        }

        if(!confirm('Konfirmasi pesanan Anda?')) return;

        const today = new Date().toLocaleDateString('en-CA');
        const queueFormatted = this.getNextQueue();
        const queueNumber = parseInt(queueFormatted);

        this.lastOrder = {
            noAntrian: queueFormatted,
            nama: this.formData.nama,
            telepon: this.formData.telepon,
            catatan: this.formData.catatan || '-',
            items: [...this.cartItems],
            total: this.calculateTotal(),
            tipe: this.orderType,
            tanggal: new Date().toLocaleDateString('id-ID'),
            jam: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
        };

        // Simpan ke Riwayat
        let orders = JSON.parse(localStorage.getItem('abi_orders') || '[]');
        orders.push(this.lastOrder);
        localStorage.setItem('abi_orders', JSON.stringify(orders));

        // Update Antrian
        localStorage.setItem('abi_last_queue', JSON.stringify({
            date: today,
            number: queueNumber
        }));

        // Reset Keranjang
        localStorage.removeItem('abi_cart');
        this.cartItems = [];
        
        // Pindah ke tampilan Struk
        this.showForm = false;
        this.showReceipt = true;
    },

    downloadReceipt() {
        window.print();
    }
}">

    <!-- Bagian List Keranjang -->
    <div x-show="!showForm && !showReceipt">
        <header class="p-6 flex items-center sticky top-0 bg-white/90 backdrop-blur-md z-10">
            <a href="/" class="p-2 bg-gray-100 rounded-xl mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800 tracking-tight text-center flex-1 mr-10 uppercase">KERANJANG</h1>
        </header>

        <main class="max-w-4xl mx-auto px-6 py-4">
            <template x-if="cartItems.length === 0">
                <div class="flex flex-col items-center justify-center min-h-[70vh]">
                    <div class="text-[40px] font-light text-gray-200 leading-none mb-4">:(</div>
                    <p class="text-gray-400 font-medium text-lg">Keranjang masih kosong</p>
                    <a href="/" class="mt-8 bg-orange-500 text-white px-8 py-3 rounded-full font-bold">Pesan Sekarang</a>
                </div>
            </template>

            <template x-if="cartItems.length > 0">
                <div class="space-y-6">
                    <template x-for="(item, index) in cartItems" :key="index">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 bg-orange-50 rounded-2xl overflow-hidden flex-shrink-0">
                                    <img :src="'/ASSET PENYETAN ABI/' + item.img" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 x-text="item.n" class="font-bold text-gray-800 text-sm"></h4>
                                    <p class="text-orange-500 font-black text-xs" x-text="'Rp ' + item.h"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center bg-gray-100 rounded-full px-3 py-1 gap-3 font-bold text-gray-700">
                                    <button @click="minusQty(index)" class="text-lg">-</button>
                                    <span class="text-xs" x-text="item.qty"></span>
                                    <button @click="addQty(index)" class="text-lg">+</button>
                                </div>
                                <button @click="removeItem(index)" class="text-gray-300 hover:text-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <div class="pt-6">
                        <div class="flex justify-between items-center mb-4 text-sm font-bold">
                            <span class="text-gray-400 uppercase tracking-widest text-[10px]">Total Bayar</span>
                            <span class="text-orange-600 text-xl">Rp <span x-text="calculateTotal().toLocaleString('id-ID')"></span></span>
                        </div>
                        <button @click="showForm = true" class="w-full bg-[#3c1609] text-white py-4 rounded-2xl font-black text-sm shadow-xl active:scale-95 transition uppercase tracking-widest">
                            CHECK OUT
                        </button>
                    </div>
                </div>
            </template>
        </main>
    </div>

    <!-- Bagian Form Data Diri -->
    <div x-show="showForm" x-cloak class="fixed inset-0 z-50 bg-white overflow-y-auto">
        <div class="max-w-md mx-auto p-6 flex flex-col min-h-screen">
            <div class="flex items-center mb-6">
                <button @click="showForm = false" class="p-2 bg-gray-100 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <div class="flex-1 text-center pr-10">
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">No. Antrian</p>
                    <span class="text-5xl font-light text-gray-900 block" x-text="getNextQueue()"></span>
                </div>
            </div>

            <div class="space-y-6 flex-1">
                <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border-b pb-2">Formulir Data Diri</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-[9px] font-bold text-gray-400 uppercase">Nama</label>
                        <input type="text" x-model="formData.nama" class="w-full border-b border-gray-200 py-1 focus:outline-none focus:border-orange-500 font-bold text-sm">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-gray-400 uppercase">Nomor Telepon</label>
                        <input type="tel" x-model="formData.telepon" class="w-full border-b border-gray-200 py-1 focus:outline-none focus:border-orange-500 font-bold text-sm">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-gray-400 uppercase">Catatan</label>
                        <input type="text" x-model="formData.catatan" class="w-full border-b border-gray-200 py-1 focus:outline-none focus:border-orange-500 font-bold text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-4">
                    <button @click="orderType = 'Makan Di Tempat'" :class="orderType === 'Makan Di Tempat' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-400'" class="py-3 rounded-xl font-bold text-xs transition-all">Makan Di Tempat</button>
                    <button @click="orderType = 'Dibungkus'" :class="orderType === 'Dibungkus' ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-400'" class="py-3 rounded-xl font-bold text-xs transition-all">Dibungkus</button>
                </div>
            </div>

            <div class="pt-6">
                <button @click="submitOrder()" class="w-full bg-[#3c1609] text-white py-4 rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl active:scale-95 transition">
                    SELESAI
                </button>
            </div>
        </div>
    </div>

    <!-- Bagian Tampilan Struk (Receipt) -->
    <div x-show="showReceipt" x-cloak class="fixed inset-0 z-[60] bg-white overflow-y-auto">
        <div id="receipt-content" class="max-w-sm mx-auto p-8 text-gray-800">
            <div class="text-center mb-6">
                <h2 class="font-black text-xl tracking-tighter uppercase">Penyetan Abi</h2>
                <p class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">No. Antrian</p>
                <span class="text-7xl font-light text-gray-900 block leading-tight" x-text="lastOrder?.noAntrian"></span>
            </div>

            <div class="space-y-1 text-[11px] mb-6 border-b border-dashed border-gray-200 pb-4">
                <div class="flex justify-between"><span>Nama Pelanggan</span><span class="font-bold" x-text="lastOrder?.nama"></span></div>
                <div class="flex justify-between"><span>No. Telepon</span><span class="font-bold" x-text="lastOrder?.telepon"></span></div>
                <div class="flex justify-between"><span>Tanggal</span><span class="font-bold" x-text="lastOrder?.tanggal"></span></div>
                <div class="flex justify-between"><span>Jam</span><span class="font-bold" x-text="lastOrder?.jam"></span></div>
                <div class="flex justify-between"><span>Catatan</span><span class="font-bold" x-text="lastOrder?.catatan"></span></div>
            </div>

            <div class="mb-6">
                <p class="text-[10px] font-black uppercase tracking-widest mb-2">Rincian Pesanan</p>
                <template x-for="item in lastOrder?.items">
                    <div class="flex justify-between text-[11px] mb-1">
                        <span x-text="item.n + ' x ' + item.qty"></span>
                        <span class="font-bold" x-text="'Rp ' + (parseInt(item.h.replace('.', '')) * item.qty).toLocaleString('id-ID')"></span>
                    </div>
                </template>
            </div>

            <div class="border-t border-black pt-2 mb-8 space-y-1">
                <div class="flex justify-between text-xs font-bold uppercase">
                    <span>Total Bayar</span>
                    <span class="text-orange-600" x-text="'Rp ' + lastOrder?.total.toLocaleString('id-ID')"></span>
                </div>
                <p class="text-[9px] font-bold text-gray-400 uppercase" x-text="lastOrder?.tipe"></p>
            </div>

            <div class="no-print space-y-3">
                <p class="text-[10px] text-center font-bold text-gray-400">Unduh Sebagai Bukti Transaksi</p>
                <button @click="downloadReceipt()" class="w-full bg-orange-500 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-orange-100">
                    Unduh <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                </button>
                <button @click="window.location.href='/'" class="w-full text-[10px] font-black text-gray-300 uppercase tracking-widest pt-4">Kembali ke Menu</button>
            </div>

            <div class="text-center mt-12 text-[10px] font-bold text-gray-400">
                <p>Jl. Perlis Utara 52 Surabaya</p>
                <p>0878 5305 3453</p>
                <p>Terima Kasih 🙏</p>
            </div>
        </div>
    </div>
</body>
</html>