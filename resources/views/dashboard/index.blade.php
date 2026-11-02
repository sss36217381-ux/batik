@extends('layouts.app')

@section('title', 'Dashboard ERP')
@section('header_title', 'Dashboard Operasional ERP')
@section('header_subtitle', 'Ringkasan Aktivitas UMKM Batik Tulis Madura & Pantauan Green SCOR')

@section('content')
<div class="space-y-6">

    <!-- Green SCOR Highlight Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 border border-emerald-700/50 rounded-2xl p-5 text-white shadow-lg relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-emerald-500/10 rounded-full blur-2xl"></div>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 relative z-10">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-emerald-500 text-slate-950">
                        Green SCOR Performance
                    </span>
                    <span class="text-xs text-emerald-300">GSCOR & Analytic Network Process (ANP)</span>
                </div>
                <h2 class="text-xl font-bold tracking-tight">Kinerja Rantai Pasok Hijau: {{ number_format($latestGscorResult->total_index ?? $dimensionScores['PLAN'] + $dimensionScores['SOURCE'] + $dimensionScores['MAKE'] + $dimensionScores['DELIVER'] + $dimensionScores['RETURN'], 2) }} / 100</h2>
                <p class="text-xs text-slate-300 mt-0.5 max-w-2xl">
                    Kategori: <strong class="text-emerald-400 font-semibold">{{ $latestGscorResult->category ?? 'Average' }}</strong>. 
                    (Data pembanding artikel penelitian terdahulu: <em class="text-amber-300">65.5225 / Average</em>. Nilai di sistem dihitung dinamis dari input operasional).
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('green-supply-chain.index') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs rounded-xl shadow transition-all">
                    <span>Detail Analitik GSCOR</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- 5 GSCOR Pillars Mini Grid -->
        <div class="grid grid-cols-5 gap-2 sm:gap-3 mt-4 pt-4 border-t border-emerald-800/60 text-center">
            <div class="p-2 bg-slate-900/60 rounded-xl border border-emerald-800/40">
                <p class="text-[10px] font-bold text-slate-400 uppercase">PLAN</p>
                <p class="text-sm font-extrabold text-emerald-400">{{ number_format($dimensionScores['PLAN'], 2) }}</p>
            </div>
            <div class="p-2 bg-slate-900/60 rounded-xl border border-emerald-800/40">
                <p class="text-[10px] font-bold text-slate-400 uppercase">SOURCE</p>
                <p class="text-sm font-extrabold text-emerald-400">{{ number_format($dimensionScores['SOURCE'], 2) }}</p>
            </div>
            <div class="p-2 bg-slate-900/60 rounded-xl border border-emerald-800/40">
                <p class="text-[10px] font-bold text-slate-400 uppercase">MAKE</p>
                <p class="text-sm font-extrabold text-amber-400">{{ number_format($dimensionScores['MAKE'], 2) }}</p>
            </div>
            <div class="p-2 bg-slate-900/60 rounded-xl border border-emerald-800/40">
                <p class="text-[10px] font-bold text-slate-400 uppercase">DELIVER</p>
                <p class="text-sm font-extrabold text-emerald-400">{{ number_format($dimensionScores['DELIVER'], 2) }}</p>
            </div>
            <div class="p-2 bg-slate-900/60 rounded-xl border border-emerald-800/40">
                <p class="text-[10px] font-bold text-slate-400 uppercase">RETURN</p>
                <p class="text-sm font-extrabold text-emerald-400">{{ number_format($dimensionScores['RETURN'], 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Main Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Penjualan -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Penjualan</span>
                <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </span>
            </div>
            <p class="text-xl font-bold text-slate-900">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                <span class="text-emerald-600 font-semibold">&bull; Transaksi Selesai</span>
            </p>
        </div>

        <!-- Total Pembelian -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pembelian</span>
                <span class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </span>
            </div>
            <p class="text-xl font-bold text-slate-900">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-500 mt-1">Pengadaan Bahan Baku</p>
        </div>

        <!-- Stok Bahan Baku -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Stok Bahan Baku</span>
                <span class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-xl font-bold text-slate-900">{{ number_format($totalMaterialStock, 0) }}</p>
                <span class="text-xs text-slate-500">Unit (Mori, Malam, dll)</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">
                @if($lowStockMaterials->count() > 0)
                    <span class="text-amber-600 font-semibold">{{ $lowStockMaterials->count() }} item menipis</span>
                @else
                    <span class="text-emerald-600">Semua bahan aman</span>
                @endif
            </p>
        </div>

        <!-- Stok Produk Batik -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kain Batik Siap Jual</span>
                <span class="w-8 h-8 rounded-lg bg-red-50 text-red-700 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <p class="text-xl font-bold text-slate-900">{{ $totalProductStock }}</p>
                <span class="text-xs text-slate-500">Lembar ({{ $totalProducts }} Motif)</span>
            </div>
            <p class="text-[11px] text-slate-500 mt-1">Gentongan, Aromanis, Lancor</p>
        </div>
    </div>

    <!-- Quick Action Toolbar -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-4 text-white flex flex-wrap items-center justify-between gap-3 shadow-sm">
        <div class="flex items-center gap-2">
            <span class="text-amber-400 font-bold text-xs uppercase tracking-wider">Aksi Cepat Operasional:</span>
        </div>
        <div class="flex flex-wrap items-center gap-2 text-xs">
            <a href="{{ route('products.index') }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-200 border border-slate-700 transition">
                + Tambah Motif Batik
            </a>
            <a href="{{ route('purchases.index') }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-200 border border-slate-700 transition">
                + Beli Bahan Baku
            </a>
            <a href="{{ route('production.index') }}" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-200 border border-slate-700 transition">
                + Order Canting Produksi
            </a>
            <a href="{{ route('sales.index') }}" class="px-3 py-1.5 bg-red-700 hover:bg-red-600 font-semibold rounded-lg text-white shadow transition">
                + Kasir Penjualan (POS)
            </a>
        </div>
    </div>

    <!-- Two Columns Section: Products & Materials Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Katalog Produk Terkini -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Katalog Produk Batik Madura</h3>
                    <p class="text-xs text-slate-500">Stok kain batik tulis gentongan & pesisiran</p>
                </div>
                <a href="{{ route('products.index') }}" class="text-xs font-semibold text-red-700 hover:text-red-900">Lihat Semua &rarr;</a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach ($recentProducts as $prod)
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-50 text-red-700 flex items-center justify-center font-bold text-xs border border-red-100">
                                {{ substr($prod->code, -2) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ $prod->name }}</h4>
                                <p class="text-[11px] text-slate-500">{{ $prod->motif_type }} &bull; {{ $prod->size }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-900">Rp {{ number_format($prod->selling_price, 0, ',', '.') }}</p>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-medium {{ $prod->isLowStock() ? 'bg-rose-50 text-rose-700 border border-rose-200' : 'bg-emerald-50 text-emerald-700' }}">
                                Stok: {{ $prod->stock }} lembar
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Persediaan Bahan Baku (Green Material Focus) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Persediaan Bahan Baku (SOURCE)</h3>
                    <p class="text-xs text-slate-500">Mori, lilin malam, dan pewarna alami</p>
                </div>
                <a href="{{ route('raw-materials.index') }}" class="text-xs font-semibold text-red-700 hover:text-red-900">Lihat Semua &rarr;</a>
            </div>

            <div class="divide-y divide-slate-100">
                @foreach ($recentMaterials as $mat)
                    <div class="py-3 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $mat->is_eco_friendly ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center font-bold text-xs">
                                {{ $mat->is_eco_friendly ? 'ECO' : 'STD' }}
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">{{ $mat->name }}</h4>
                                <p class="text-[11px] text-slate-500">Kat: {{ ucfirst(str_replace('_', ' ', $mat->category)) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-900">{{ number_format($mat->stock, 2) }} {{ $mat->unit }}</p>
                            <span class="text-[10px] text-slate-500">Min: {{ number_format($mat->min_stock, 0) }} {{ $mat->unit }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
