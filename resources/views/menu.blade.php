<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Penyetan Abi - Sego Sambal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; overflow-x: hidden; }
        @keyframes simple-pop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-pop { animation: simple-pop 0.6s ease-out forwards; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        [x-cloak] { display: none !important; }

        @media print {
            body * { visibility: hidden; }
            #receipt-modal-content, #receipt-modal-content * { visibility: visible; }
            #receipt-modal-content { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" 
      x-data="{ 
        showSplash: true, 
        showOrders: false,
        showReceiptDetail: false,
        selectedOrder: null,
        cartItems: [],
        orders: [],
        cartCount: 0, 
        mailCount: 0, 
        selectedCategory: 'tanpa-nasi',
        isScrolled: false,
        isAdded(itemName) {
            return this.cartItems.some(item => item.n === itemName);
        },
        openReceipt(order) {
            this.selectedOrder = order;
            this.showReceiptDetail = true;
        }
      }" 
      x-init="
        setTimeout(() => showSplash = false, 2000);
        window.addEventListener('scroll', () => { isScrolled = window.scrollY > 20 });
        const savedCart = JSON.parse(localStorage.getItem('abi_cart') || '[]');
        cartItems = savedCart;
        cartCount = cartItems.length;
        const savedOrders = JSON.parse(localStorage.getItem('abi_orders') || '[]');
        orders = savedOrders;
        mailCount = orders.length;
      ">

    <!-- Splash Screen -->
    <div x-show="showSplash" 
         class="fixed inset-0 z-[9999] bg-[#3c1609] flex flex-col items-center justify-center p-6 text-center">
        <h1 class="text-white text-2xl font-black tracking-[0.3em] uppercase mb-8">PENYETAN ABI</h1>
        <div class="w-48 h-48 md:w-96 md:h-96 animate-pop">
            <img src="/ASSET PENYETAN ABI/splashscreen (2).png" alt="Splash Abi" class="w-full h-full object-contain">
        </div>
        <h2 class="text-white text-lg font-bold tracking-widest mt-8 uppercase">Sego Sambel</h2>
    </div>

    <main x-show="!showSplash" x-cloak class="relative w-full overflow-x-hidden">
        <!-- Header -->
        <header :class="isScrolled ? 'py-3 shadow-md' : 'py-5'" 
                class="fixed top-0 inset-x-0 bg-white/95 backdrop-blur-md z-50 transition-all duration-300 px-4">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div @click="showOrders = true" class="relative cursor-pointer bg-gray-100 p-2 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <template x-if="mailCount > 0">
                        <span x-text="mailCount" class="absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white animate-bounce"></span>
                    </template>
                </div>

                <div class="text-center">
                    <h2 class="text-lg font-black text-gray-800 tracking-tight">PENYETAN <span class="text-orange-500">ABI</span></h2>
                    <p class="text-[9px] font-bold text-orange-600 uppercase tracking-widest" x-show="isScrolled">Mau pesan apa?</p>
                </div>
                
                <a href="/keranjang" class="relative bg-orange-500 p-2 rounded-xl text-white shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <template x-if="cartCount > 0">
                        <span x-text="cartCount" class="absolute -top-1 -right-1 bg-[#3c1609] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white"></span>
                    </template>
                </a>
            </div>
        </header>

        <!-- Banner -->
        <div class="px-4 mt-24 mb-8">
            <div class="max-w-7xl mx-auto w-full h-48 md:h-80 bg-gradient-to-br from-orange-500 to-red-600 rounded-[2rem] flex items-center p-6 md:p-12 text-white relative overflow-hidden shadow-xl">
                <div class="z-10 relative">
                    <h3 class="text-2xl md:text-5xl font-black mb-4 leading-tight">Hai, mau <br> pesan apa?</h3>
                    <button @click="document.getElementById('menu-section').scrollIntoView({ behavior: 'smooth' })" 
                            class="bg-white text-orange-600 px-5 py-2 rounded-full font-bold text-xs md:text-base">
                        Lihat Menu
                    </button>
                </div>
                <div class="absolute -right-8 -bottom-8 opacity-20 text-[10rem] md:text-[15rem] rotate-12 select-none">🍗</div>
            </div>
        </div>

        <!-- Menu Section -->
        <div id="menu-section" class="max-w-7xl mx-auto px-6 py-12 scroll-mt-24">
            <div class="flex items-center space-x-4 mb-8 overflow-x-auto no-scrollbar pb-2">
                <button @click="selectedCategory = 'tanpa-nasi'" :class="selectedCategory === 'tanpa-nasi' ? 'bg-orange-500 text-white shadow-lg' : 'bg-gray-100 text-gray-500'" class="px-8 py-3 rounded-full text-sm font-bold transition-all whitespace-nowrap tracking-tight">Tanpa Nasi</button>
                <button @click="selectedCategory = 'paket-komplit'" :class="selectedCategory === 'paket-komplit' ? 'bg-orange-500 text-white shadow-lg' : 'bg-gray-100 text-gray-500'" class="px-8 py-3 rounded-full text-sm font-bold transition-all whitespace-nowrap tracking-tight">Paket Komplit</button>
                <button @click="selectedCategory = 'ala-carte'" :class="selectedCategory === 'ala-carte' ? 'bg-orange-500 text-white shadow-lg' : 'bg-gray-100 text-gray-500'" class="px-8 py-3 rounded-full text-sm font-bold transition-all whitespace-nowrap tracking-tight">Ala Carte</button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8 transition-all duration-300">
                <!-- Tanpa Nasi Template -->
                <template x-for="i in [{n:'Tahu Tempe', h:'10.000', img:'TAHU TEMPE.png'}, {n:'Telor + Tahu + Tempe', h:'10.000', img:'TELOR.png'}, {n:'Lele + Tahu + Tempe', h:'10.000', img:'LELE.png'}, {n:'Hati Ayam + Tahu + Tempe', h:'10.000', img:'REMPELO ATI.png'}]">
                    <div x-show="selectedCategory === 'tanpa-nasi'" x-transition class="group bg-white rounded-3xl border border-gray-100 p-3 md:p-4 hover:shadow-2xl transition-all relative">
                        <input type="checkbox" :checked="isAdded(i.n)" @change="let cart = JSON.parse(localStorage.getItem('abi_cart') || '[]'); if ($el.checked) { cart.push({ ...i, qty: 1 }); cartCount++; } else { cart = cart.filter(item => item.n !== i.n); cartCount--; } localStorage.setItem('abi_cart', JSON.stringify(cart)); cartItems = cart;" class="absolute top-5 left-5 w-6 h-6 rounded-lg border-gray-300 text-orange-500 z-10 cursor-pointer shadow-sm">
                        <div class="aspect-square bg-orange-100 rounded-2xl mb-4 overflow-hidden relative"><img :src="'/ASSET PENYETAN ABI/' + i.img" class="w-full h-full object-cover group-hover:scale-110 transition duration-500"></div>
                        <div class="text-center px-2"><h4 class="font-bold text-xs md:text-lg text-gray-800 line-clamp-2 leading-tight h-8 md:h-12" x-text="i.n"></h4><p class="text-orange-600 font-black text-xs md:text-base mt-1" x-text="'Rp ' + i.h"></p></div>
                    </div>
                </template>

                <!-- Paket Komplit Template -->
                <template x-for="i in [{n:'Telor + Tahu + Tempe', h:'20.000', img:'TELOR.png'}, {n:'Ikan Asin + tahu + Tempe', h:'22.000', img:'IKAN ASIN.png'}, {n:'Usus + tahu + Tempe', h:'30.000', img:'USUS.png'}, {n:'Hati Ayam + Tahu + Tempe', h:'25.000', img:'REMPELO ATI.png'}, {n:'Lele + Tahu + Tempe', h:'15.000', img:'LELE.png'}, {n:'Ikan Pe + Tahu + Tempe', h:'18.000', img:'IKAN PE.png'}, {n:'Ayam + Tahu + Tempe', h:'22.000', img:'AYAM.png'}, {n:'Dorang + Tahu + Tempe', h:'28.000', img:'DORANG.png'}, {n:'Mujair + Tahu + Tempe', h:'35.000', img:'MUJAIR.png'}]">
                    <div x-show="selectedCategory === 'paket-komplit'" x-transition class="group bg-white rounded-3xl border border-gray-100 p-3 md:p-4 hover:shadow-2xl transition-all relative">
                        <input type="checkbox" :checked="isAdded(i.n)" @change="let cart = JSON.parse(localStorage.getItem('abi_cart') || '[]'); if ($el.checked) { cart.push({ ...i, qty: 1 }); cartCount++; } else { cart = cart.filter(item => item.n !== i.n); cartCount--; } localStorage.setItem('abi_cart', JSON.stringify(cart)); cartItems = cart;" class="absolute top-5 left-5 w-6 h-6 rounded-lg border-gray-300 text-orange-500 z-10 cursor-pointer shadow-sm">
                        <div class="aspect-square bg-orange-50 rounded-2xl mb-4 overflow-hidden relative"><img :src="'/ASSET PENYETAN ABI/' + i.img" class="w-full h-full object-cover group-hover:scale-110 transition duration-500"></div>
                        <div class="text-center px-2"><h4 class="font-bold text-xs md:text-lg text-gray-800 line-clamp-2 leading-tight h-8 md:h-12" x-text="i.n"></h4><p class="text-orange-600 font-black text-xs md:text-base mt-1" x-text="'Rp ' + i.h"></p></div>
                    </div>
                </template>

                <!-- Ala Carte Template -->
                <template x-for="i in [{n:'Sambal', h:'1.000', img:'T_SAMBAL.png'}, {n:'Tahu', h:'1.000', img:'T_TAHU.png'}, {n:'Tempe', h:'1.000', img:'T_TEMPE.png'}, {n:'Kemangi', h:'2.000', img:'T_KEMANGI.png'}, {n:'Timun', h:'2.000', img:'T_TIMUN.png'}, {n:'Tumis Kangkung', h:'2.000', img:'T_KANGKUNG.png'}, {n:'Terong Goreng', h:'2.000', img:'T_TERONG.png'}, {n:'Telor', h:'3.000', img:'T_TELOR.png'}, {n:'Hati Ayam', h:'3.000', img:'T_HATI AYAM.png'}, {n:'Usus', h:'4.000', img:'T_USUS.png'}, {n:'Nasi', h:'5.000', img:'NASI.png'}, {n:'Ayam', h:'6.000', img:'T_AYAM.png'}, {n:'Ikan Pe', h:'6.000', img:'T_IKAN PE.png'}, {n:'Mujair', h:'7.000', img:'T_MUJAIR.png'}]">
                    <div x-show="selectedCategory === 'ala-carte'" x-transition class="group bg-white rounded-3xl border border-gray-100 p-3 md:p-4 hover:shadow-2xl transition-all relative">
                        <input type="checkbox" :checked="isAdded(i.n)" @change="let cart = JSON.parse(localStorage.getItem('abi_cart') || '[]'); if ($el.checked) { cart.push({ ...i, qty: 1 }); cartCount++; } else { cart = cart.filter(item => item.n !== i.n); cartCount--; } localStorage.setItem('abi_cart', JSON.stringify(cart)); cartItems = cart;" class="absolute top-5 left-5 w-6 h-6 rounded-lg border-gray-300 text-orange-500 z-10 cursor-pointer shadow-sm">
                        <div class="aspect-square bg-orange-50 rounded-2xl mb-4 overflow-hidden relative"><img :src="'/ASSET PENYETAN ABI/' + i.img" class="w-full h-full object-cover group-hover:scale-110 transition duration-500"></div>
                        <div class="text-center px-2"><h4 class="font-bold text-xs md:text-lg text-gray-800 line-clamp-2 leading-tight h-8 md:h-12" x-text="i.n"></h4><p class="text-orange-600 font-black text-xs md:text-base mt-1" x-text="'Rp ' + i.h"></p></div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Float Cart Button -->
        <div x-show="cartCount > 0" x-transition class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[40] w-full max-w-7xl px-6">
            <a href="/keranjang" class="bg-[#3c1609] text-white flex items-center justify-between p-4 rounded-2xl shadow-2xl active:scale-95 transition-all">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500 p-2 rounded-lg relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        <span class="absolute -top-1 -right-1 bg-white text-[#3c1609] text-[8px] font-black w-4 h-4 flex items-center justify-center rounded-full border border-[#3c1609]" x-text="cartCount"></span>
                    </div>
                    <div><p class="text-[10px] font-bold text-orange-400 uppercase tracking-widest leading-none">Penyetan Abi</p><h4 class="font-black text-sm uppercase tracking-tighter">Pesan Sekarang</h4></div>
                </div>
                <div class="flex items-center gap-2 bg-white/10 px-3 py-2 rounded-xl"><span class="text-xs font-bold uppercase tracking-widest">Lanjut</span><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg></div>
            </a>
        </div>
    </main>

    <!-- Modal Riwayat Pesanan -->
    <div x-show="showOrders" x-cloak class="fixed inset-0 z-[100] bg-white overflow-y-auto px-4 py-6">
        <div class="max-w-md mx-auto min-h-full flex flex-col">
            <header class="flex items-center mb-8 sticky top-0 bg-white py-2 z-10">
                <button @click="showOrders = false" class="p-2 bg-gray-100 rounded-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                <h2 class="flex-1 text-center font-black text-gray-800 pr-10 uppercase text-xs tracking-widest">Pesanan Saya</h2>
            </header>

            <template x-if="orders.length === 0">
                <div class="flex-1 flex flex-col items-center justify-center py-20 text-center"><div class="text-7xl font-light text-gray-100 mb-4 select-none">:(</div><p class="text-gray-400 text-sm font-medium uppercase tracking-widest">Riwayat Kosong</p></div>
            </template>

            <template x-if="orders.length > 0">
                <div class="space-y-6 pb-10">
                    <template x-for="(order, index) in orders" :key="index">
                        <div class="p-6 rounded-[2.5rem] border border-gray-100 bg-orange-50/30 shadow-sm relative">
                            <div class="flex justify-between items-start mb-6">
                                <div><p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">No. Antrian</p><h3 class="text-6xl font-light text-gray-900 leading-none -ml-1" x-text="order.noAntrian"></h3></div>
                                <div class="flex flex-col items-end gap-2">
                                    <div class="flex items-center gap-1.5 bg-white px-3 py-1.5 rounded-full shadow-sm border border-orange-100"><span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span><span class="text-[8px] font-black text-orange-600 uppercase tracking-widest">Sedang Dimasak</span></div>
                                    <span class="bg-[#b3a125] text-[#3c1609] text-[8px] px-3 py-1 rounded-full font-black uppercase tracking-tighter" x-text="order.tipe"></span>
                                </div>
                            </div>
                            <div class="mb-4"><p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Atas Nama:</p><p class="text-lg font-black text-gray-800 uppercase tracking-tight" x-text="order.nama"></p></div>
                            
                            <!-- Tombol Lihat Struk -->
                            <button @click="openReceipt(order)" class="w-full mt-2 py-3 bg-white border border-orange-200 text-orange-500 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-500 hover:text-white transition-all active:scale-95 shadow-sm">Lihat Detail Struk</button>
                        </div>
                    </template>
                    <button @click="if(confirm('Hapus riwayat pesanan?')){ localStorage.removeItem('abi_orders'); orders = []; mailCount = 0; }" class="w-full mt-6 py-4 text-[10px] font-bold text-gray-300 uppercase tracking-[0.3em]">Bersihkan Riwayat</button>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL DETAIL STRUK (Hidden by default) -->
    <div x-show="showReceiptDetail" x-cloak class="fixed inset-0 z-[200] bg-white overflow-y-auto" x-transition>
        <div id="receipt-modal-content" class="max-w-sm mx-auto p-8 text-gray-800 min-h-screen flex flex-col">
            <!-- Header Struk -->
            <div class="text-center mb-6">
                <button @click="showReceiptDetail = false" class="no-print absolute top-8 left-8 p-2 bg-gray-50 rounded-xl"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                <h2 class="font-black text-xl tracking-tighter uppercase">Penyetan Abi</h2>
                <p class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">No. Antrian</p>
                <span class="text-7xl font-light text-gray-900 block leading-tight" x-text="selectedOrder?.noAntrian"></span>
            </div>

            <!-- Info Pelanggan -->
            <div class="space-y-1 text-[11px] mb-6 border-b border-dashed border-gray-200 pb-4">
                <div class="flex justify-between"><span>Nama Pelanggan</span><span class="font-bold uppercase" x-text="selectedOrder?.nama"></span></div>
                <div class="flex justify-between"><span>No. Telepon</span><span class="font-bold" x-text="selectedOrder?.telepon"></span></div>
                <div class="flex justify-between"><span>Tanggal</span><span class="font-bold" x-text="selectedOrder?.tanggal"></span></div>
                <div class="flex justify-between"><span>Jam</span><span class="font-bold" x-text="selectedOrder?.jam"></span></div>
                <div class="flex justify-between"><span>Catatan</span><span class="font-bold" x-text="selectedOrder?.catatan || '-'"></span></div>
            </div>

            <!-- Rincian Menu -->
            <div class="mb-6 flex-1">
                <p class="text-[10px] font-black uppercase tracking-widest mb-2">Rincian Pesanan</p>
                <template x-for="item in selectedOrder?.items">
                    <div class="flex justify-between text-[11px] mb-1">
                        <span x-text="item.qty + 'x ' + item.n"></span>
                        <span class="font-bold" x-text="'Rp ' + (parseInt(item.h.replace('.', '')) * item.qty).toLocaleString('id-ID')"></span>
                    </div>
                </template>
            </div>

            <!-- Total -->
            <div class="border-t border-black pt-2 mb-8 space-y-1">
                <div class="flex justify-between text-xs font-bold uppercase">
                    <span>Total Bayar</span>
                    <span class="text-orange-600" x-text="'Rp ' + selectedOrder?.total.toLocaleString('id-ID')"></span>
                </div>
                <p class="text-[9px] font-bold text-gray-400 uppercase" x-text="selectedOrder?.tipe"></p>
            </div>

            <!-- Footer & Aksi -->
            <div class="no-print space-y-3 mt-auto">
                <button @click="window.print()" class="w-full bg-orange-500 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-orange-100">
                    Unduh Struk <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                </button>
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