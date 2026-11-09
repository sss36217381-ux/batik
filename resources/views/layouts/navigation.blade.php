<!-- Desktop & Mobile Sidebar Container -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
       class="fixed inset-y-0 left-0 z-30 w-72 bg-slate-900 border-r border-slate-800 transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col justify-between shadow-xl">

    <!-- Logo & Brand Header -->
    <div>
        <div class="h-16 px-6 bg-gradient-to-r from-red-950 via-slate-900 to-slate-900 border-b border-red-900/40 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 via-red-600 to-red-800 flex items-center justify-center text-white font-black text-lg shadow-md border border-amber-300/30">
                    BM
                </div>
                <div>
                    <span class="text-sm font-extrabold tracking-wider text-white uppercase block leading-tight">ERP BATIK</span>
                    <span class="text-[10px] font-semibold text-amber-400 tracking-widest uppercase block">Tulis Madura</span>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Menus (Scrollable) -->
        <nav class="px-4 py-4 space-y-6 overflow-y-auto max-h-[calc(100vh-8.5rem)] text-xs font-medium">

            <!-- KELOMPOK 1: UTAMA -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Utama</p>
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'bg-red-700 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span>Dashboard ERP</span>
                    </a>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('users.*') ? 'bg-red-700 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>Manajemen Pengguna</span>
                    </a>
                    @endif
                </div>
            </div>

            <!-- KELOMPOK 2: MASTER DATA -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Master Data</p>
                <div class="space-y-1">
                    <a href="{{ route('suppliers.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('suppliers.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>Data Pemasok (Supplier)</span>
                    </a>

                    <a href="{{ route('customers.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('customers.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Data Pelanggan</span>
                    </a>

                    <a href="{{ route('products.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('products.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                        </svg>
                        <span>Data Produk Batik</span>
                    </a>

                    <a href="{{ route('raw-materials.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('raw-materials.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span>Bahan Baku (Mori & Malam)</span>
                    </a>
                </div>
            </div>

            <!-- KELOMPOK 3: OPERASIONAL SUPPLY CHAIN -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Operasional Rantai Pasok</p>
                <div class="space-y-1">
                    <a href="{{ route('purchases.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('purchases.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>Pembelian Bahan (SOURCE)</span>
                    </a>

                    <a href="{{ route('inventory.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('inventory.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <span>Persediaan & Gudang</span>
                    </a>

                    <a href="{{ route('production.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('production.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                        <span>Produksi Batik (MAKE)</span>
                    </a>

                    <a href="{{ route('sales.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('sales.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Penjualan Batik (POS)</span>
                    </a>

                    <a href="{{ route('shipments.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('shipments.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                        </svg>
                        <span>Pengiriman (DELIVER)</span>
                    </a>

                    <a href="{{ route('returns.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('returns.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        <span>Retur Produk (RETURN)</span>
                    </a>
                </div>
            </div>

            <!-- KELOMPOK 4: KEUANGAN, LAPORAN & GREEN SCOR -->
            <div>
                <p class="px-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Finansial & Analitika</p>
                <div class="space-y-1">
                    @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
                    <a href="{{ route('finance.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('finance.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <span>Keuangan & Laba Rugi</span>
                    </a>
                    @endif

                    <a href="{{ route('reports.index') }}" 
                       class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all {{ request()->routeIs('reports.*') ? 'bg-red-700 text-white font-semibold' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}">
                        <svg class="w-4 h-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Laporan Terpadu</span>
                    </a>

                    <a href="{{ route('green-supply-chain.index') }}" 
                       class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all {{ request()->routeIs('green-supply-chain.*') ? 'bg-emerald-600 text-white font-bold shadow-md ring-1 ring-emerald-300/40' : 'text-emerald-300 bg-emerald-950/40 hover:bg-emerald-900/50 hover:text-white border border-emerald-800/40' }}">
                        <svg class="w-4 h-4 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="flex-1">Green SCOR Analytics</span>
                        <span class="text-[9px] bg-emerald-500 text-slate-900 font-extrabold px-1.5 py-0.5 rounded">GSCOR</span>
                    </a>
                </div>
            </div>

        </nav>
    </div>

    <!-- User Profile & Sign-out footer -->
    <div class="p-4 border-t border-slate-800 bg-slate-950/70">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-red-900 text-red-100 flex items-center justify-center font-bold text-xs ring-2 ring-red-700/50">
                {{ substr(auth()->user()->name, 0, 2) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-slate-400 truncate">{{ auth()->user()->role?->display_name ?? 'User' }}</p>
            </div>
        </div>
    </div>
</aside>

