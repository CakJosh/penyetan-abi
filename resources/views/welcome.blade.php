<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyetan Abi - Sego Sambel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        @keyframes simple-pop {
            0% { transform: scale(0.8); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        .animate-pop {
            animation: simple-pop 0.6s ease-out forwards;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-gray-50" 
      x-data="{ 
        showSplash: true, 
        cartCount: 0, 
        mailCount: 0, 
        selectedCategory: 'tanpa-nasi',
        isScrolled: false 
      }" 
      x-init="
        setTimeout(() => showSplash = false, 3500);
        window.addEventListener('scroll', () => { isScrolled = window.scrollY > 60 })
      ">

    <div x-show="showSplash" 
         x-transition:leave="transition ease-in duration-700"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] bg-[#3c1609] flex flex-col items-center justify-center overflow-hidden">
        
        <div class="flex flex-col items-center text-center">
            <h1 class="text-white text-2xl md:text-4xl font-black tracking-[0.3em] uppercase mb-8">
                PENYETAN ABI
            </h1>
            <div class="w-64 h-64 md:w-96 md:h-96 animate-pop">
                <img src="/ASSET PENYETAN ABI/splashscreen (2).png" alt="Splash Abi" class="w-full h-full object-contain">
            </div>
            <h2 class="text-white text-xl md:text-2xl font-bold tracking-widest mt-8 uppercase">
                Sego Sambel
            </h2>
        </div>
    </div>

    <main x-show="!showSplash" x-transition.duration.1000ms class="min-h-screen bg-white">
        
        <header class="max-w-7xl mx-auto p-4 md:p-6 flex justify-between items-center sticky top-0 bg-white/95 backdrop-blur-md z-50 border-b border-gray-100 transition-all duration-300">
            
            <div class="relative cursor-pointer bg-gray-100 p-2.5 rounded-xl hover:bg-orange-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <template x-if="mailCount > 0">
                    <span x-text="mailCount" class="absolute -top-1 -right-1 bg-orange-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white animate-bounce"></span>
                </template>
            </div>

            <div class="text-center flex-1 mx-4">
                <h2 x-show="!isScrolled" x-transition:enter="transition duration-300" class="text-xl md:text-2xl font-black text-gray-800 tracking-tight">
                    PENYETAN <span class="text-orange-500">ABI</span>
                </h2>
                <h2 x-show="isScrolled" x-transition:enter="transition duration-300" class="text-base md:text-lg font-bold text-orange-600 italic">
                    Hai, mau pesan apa?
                </h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <nav class="hidden md:flex space-x-8 text-sm font-bold text-gray-600 mr-4">
                    <a href="#" class="hover:text-orange-500 transition">HOME</a>
                    <a href="#" class="text-orange-500 underline underline-offset-8">MENU</a>
                    <a href="#" class="hover:text-orange-500 transition">PROMO</a>
                </nav>

                <div class="relative cursor-pointer bg-orange-500 p-2.5 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-orange-100 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <template x-if="cartCount > 0">
                        <span x-text="cartCount" class="absolute -top-1 -right-1 bg-[#3c1609] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white"></span>
                    </template>
                </div>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-6 mt-6">
            <div class="w-full h-[250px] md:h-[400px] bg-gradient-to-r from-orange-500 to-red-600 rounded-[2.5rem] flex items-center p-8 md:p-12 text-white overflow-hidden relative shadow-2xl shadow-orange-200">
                <div class="z-10 max-w-lg">
                    <h3 class="text-4xl md:text-6xl font-black mb-6 leading-tight">Hai, mau <br> pesan apa?</h3>
                    <button class="bg-white text-orange-600 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition shadow-lg text-sm md:text-base">Lihat Menu</button>
                </div>
                <div class="absolute right-[-30px] top-[-30px] opacity-20 text-[15rem] md:text-[20rem] rotate-12 select-none">🍗</div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 py-12">
            <div class="flex items-center space-x-4 mb-10 overflow-x-auto no-scrollbar pb-4">
                <button @click="selectedCategory = 'tanpa-nasi'" :class="selectedCategory === 'tanpa-nasi' ? 'bg-orange-500 text-white shadow-lg shadow-orange-200' : 'bg-gray-100 text-gray-500'" class="px-8 py-3 rounded-full text-sm font-bold transition-all whitespace-nowrap">Tanpa Nasi</button>
                <button @click="selectedCategory = 'paket-komplit'" :class="selectedCategory === 'paket-komplit' ? 'bg-orange-500 text-white shadow-lg shadow-orange-200' : 'bg-gray-100 text-gray-500'" class="px-8 py-3 rounded-full text-sm font-bold transition-all whitespace-nowrap">Paket Komplit</button>
                <button @click="selectedCategory = 'ala-carte'" :class="selectedCategory === 'ala-carte' ? 'bg-orange-500 text-white shadow-lg shadow-orange-200' : 'bg-gray-100 text-gray-500'" class="px-8 py-3 rounded-full text-sm font-bold transition-all whitespace-nowrap">Ala Carte</button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8">
                <div class="group bg-white rounded-3xl border border-gray-100 p-3 md:p-4 hover:shadow-2xl hover:shadow-gray-200 transition-all">
                    <div class="aspect-square md:aspect-video bg-orange-100 rounded-2xl mb-4 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1580447331518-86bc052e779a?auto=format&fit=crop&w=500" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-sm md:text-xl text-gray-800">Penyetan Lele</h4>
                            <p class="text-orange-600 font-black text-xs md:text-lg mt-1">Rp 15.000</p>
                        </div>
                        <input type="checkbox" @change="$el.checked ? cartCount++ : cartCount--" class="w-6 h-6 md:w-7 md:h-7 rounded-lg border-gray-300 text-orange-500 focus:ring-orange-500 cursor-pointer">
                    </div>
                </div>

                <div class="group bg-white rounded-3xl border border-gray-100 p-3 md:p-4 hover:shadow-2xl hover:shadow-gray-200 transition-all">
                    <div class="aspect-square md:aspect-video bg-orange-100 rounded-2xl mb-4 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&w=500" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    </div>
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-bold text-sm md:text-xl text-gray-800">Penyetan Ikan Pe</h4>
                            <p class="text-orange-600 font-black text-xs md:text-lg mt-1">Rp 18.000</p>
                        </div>
                        <input type="checkbox" @change="$el.checked ? cartCount++ : cartCount--" class="w-7 h-7 rounded-lg border-gray-300 text-orange-500 focus:ring-orange-500 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>