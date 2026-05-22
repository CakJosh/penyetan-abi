<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Penyetan Abi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght=400;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .animate-pop { animation: pop 0.3s ease-out forwards; }
        @keyframes pop { 0% { transform: scale(0.95); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
    </style>
</head>
<body class="bg-[#3c1609] min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white rounded-[2.5rem] p-8 shadow-2xl">
        <div class="text-center mb-6">
            <h1 class="text-[#3c1609] text-2xl font-black tracking-widest uppercase">PENYETAN ABI ADMIN</h1>
            <p class="text-orange-500 text-[10px] font-bold uppercase tracking-widest mt-1">Silakan Login Terlebih Dahulu</p>
        </div>

        {{-- BOX POP-UP PERINGATAN ERROR --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl animate-pop text-center">
                <p class="text-red-700 text-[11px] font-black uppercase tracking-widest leading-relaxed">
                    {{ $errors->first() }}
                </p>
            </div>
        @endif

        <form action="{{ url('/admin/login') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required class="w-full border-b-2 border-gray-100 py-2 focus:border-orange-500 outline-none font-bold text-gray-700 transition" autocomplete="off">
            </div>

            <div>
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Password</label>
                <input type="password" name="password" required class="w-full border-b-2 border-gray-100 py-2 focus:border-orange-500 outline-none font-bold text-gray-700 transition">
            </div>

            <button type="submit" class="w-full bg-orange-500 text-white py-4 rounded-2xl font-black shadow-xl hover:bg-black transition active:scale-95 uppercase tracking-widest">
                MASUK DASHBOARD
            </button>
        </form>
    </div>

</body>
</html>