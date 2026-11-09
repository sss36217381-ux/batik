<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - ERP Batik Tulis Madura</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: radial-gradient(circle at 20% 20%, rgba(153, 27, 27, 0.25) 0%, rgba(15, 23, 42, 1) 70%);
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo & Brand Header -->
        <div class="text-center mb-6">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-tr from-amber-600 via-red-700 to-red-900 items-center justify-center text-white font-extrabold text-2xl shadow-xl shadow-red-950/60 border border-amber-300/30 mb-3">
                BM
            </div>
            <h1 class="text-2xl font-black text-white tracking-wide uppercase">ERP Batik Madura</h1>
            <p class="text-xs text-amber-300/80 font-medium">Enterprise Resource Planning Berbasis Green SCOR &bull; UMKM Batik Tulis Madura</p>
        </div>

        <!-- Login Card -->
        <div class="bg-slate-800/90 border border-slate-700/80 rounded-2xl p-6 sm:p-8 shadow-2xl backdrop-blur-sm">
            
            @if (session('success'))
                <div class="mb-4 p-3 bg-emerald-950/70 border border-emerald-700/50 rounded-xl text-emerald-200 text-xs">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 bg-rose-950/70 border border-rose-700/50 rounded-xl text-rose-200 text-xs">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-200 mb-1.5">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@batikmadura.id') }}" required autofocus
                           class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all placeholder-slate-500"
                           placeholder="nama@batikmadura.id">
                    @error('email')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-semibold text-slate-200">Kata Sandi</label>
                        <span class="text-[11px] text-amber-400/80">Default: password</span>
                    </div>
                    <input type="password" id="password" name="password" value="password" required
                           class="w-full px-3.5 py-2.5 bg-slate-900 border border-slate-700 rounded-xl text-white text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all placeholder-slate-500"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-slate-300 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-700 bg-slate-900 text-red-600 focus:ring-red-500">
                        <span>Ingat sesi saya</span>
                    </label>
                    <span class="text-slate-500">RPS Minggu 1</span>
                </div>

                <button type="submit" 
                        class="w-full py-2.5 px-4 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-600 hover:to-red-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-red-950 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-800 focus:ring-red-500 mt-2">
                    Masuk ke Sistem ERP
                </button>
            </form>

            <!-- Quick Demo Role Switcher -->
            <div class="mt-6 pt-5 border-t border-slate-700/80">
                <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2.5 text-center">
                    Akses Cepat Pengujian Role (Demo Dummy)
                </p>
                <div class="grid grid-cols-3 gap-1.5 text-[11px]">
                    <button type="button" onclick="fillCredential('admin@batikmadura.id')" 
                            class="px-2 py-1.5 bg-slate-900/80 hover:bg-red-900/60 text-slate-200 border border-slate-700 hover:border-red-700 rounded-lg text-center transition-all truncate">
                        👑 Admin
                    </button>
                    <button type="button" onclick="fillCredential('pemilik@batikmadura.id')" 
                            class="px-2 py-1.5 bg-slate-900/80 hover:bg-amber-900/60 text-slate-200 border border-slate-700 hover:border-amber-700 rounded-lg text-center transition-all truncate">
                        💼 Pemilik
                    </button>
                    <button type="button" onclick="fillCredential('gudang@batikmadura.id')" 
                            class="px-2 py-1.5 bg-slate-900/80 hover:bg-indigo-900/60 text-slate-200 border border-slate-700 hover:border-indigo-700 rounded-lg text-center transition-all truncate">
                        📦 Gudang
                    </button>
                    <button type="button" onclick="fillCredential('produksi@batikmadura.id')" 
                            class="px-2 py-1.5 bg-slate-900/80 hover:bg-orange-900/60 text-slate-200 border border-slate-700 hover:border-orange-700 rounded-lg text-center transition-all truncate">
                        🎨 Produksi
                    </button>
                    <button type="button" onclick="fillCredential('pembelian@batikmadura.id')" 
                            class="px-2 py-1.5 bg-slate-900/80 hover:bg-cyan-900/60 text-slate-200 border border-slate-700 hover:border-cyan-700 rounded-lg text-center transition-all truncate">
                        🛒 Pembelian
                    </button>
                    <button type="button" onclick="fillCredential('penjualan@batikmadura.id')" 
                            class="px-2 py-1.5 bg-slate-900/80 hover:bg-teal-900/60 text-slate-200 border border-slate-700 hover:border-teal-700 rounded-lg text-center transition-all truncate">
                        💳 Penjualan
                    </button>
                </div>
            </div>

        </div>

        <p class="text-center text-xs text-slate-500 mt-5">
            Manajemen & Proyek Sistem Informasi &bull; SQA & V-Model Baseline
        </p>
    </div>

    <script>
        function fillCredential(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    </script>
</body>
</html>

