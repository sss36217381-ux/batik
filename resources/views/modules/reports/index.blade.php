@extends('layouts.app')

@section('title', 'Laporan Terpadu')
@section('header_title', 'Pusat Laporan Terpadu ERP')
@section('header_subtitle', 'Ringkasan laporan operasional, persediaan gudang, keuangan, dan mitra rantai pasok')

@section('content')
<div class="space-y-6">

    <!-- Reports Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- Laporan Penjualan -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-900 text-sm">Laporan Penjualan</h3>
                <span class="p-2 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold">POS</span>
            </div>
            <div class="space-y-2 text-xs text-slate-600">
                <div class="flex justify-between">
                    <span>Total Transaksi Selesai:</span>
                    <strong class="text-slate-900">{{ $salesCount }} faktur</strong>
                </div>
                <div class="flex justify-between">
                    <span>Akumulasi Omzet:</span>
                    <strong class="text-emerald-700">Rp {{ number_format($salesTotal, 0, ',', '.') }}</strong>
                </div>
                <div class="flex justify-between">
                    <span>Basis Pelanggan:</span>
                    <strong class="text-slate-900">{{ $customerCount }} kontak</strong>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('sales.index') }}" class="text-xs font-semibold text-red-700 hover:text-red-900 flex items-center gap-1">
                    Buka Detail Transaksi Penjualan &rarr;
                </a>
            </div>
        </div>

        <!-- Laporan Pengadaan & Pembelian -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-900 text-sm">Laporan Pengadaan (SOURCE)</h3>
                <span class="p-2 bg-sky-50 text-sky-600 rounded-lg text-xs font-bold">PO</span>
            </div>
            <div class="space-y-2 text-xs text-slate-600">
                <div class="flex justify-between">
                    <span>Order Pembelian:</span>
                    <strong class="text-slate-900">{{ $purchaseCount }} order</strong>
                </div>
                <div class="flex justify-between">
                    <span>Total Belanja Bahan:</span>
                    <strong class="text-rose-700">Rp {{ number_format($purchaseTotal, 0, ',', '.') }}</strong>
                </div>
                <div class="flex justify-between">
                    <span>Jumlah Pemasok:</span>
                    <strong class="text-slate-900">{{ $supplierCount }} mitra</strong>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('purchases.index') }}" class="text-xs font-semibold text-red-700 hover:text-red-900 flex items-center gap-1">
                    Buka Detail Pembelian &rarr;
                </a>
            </div>
        </div>

        <!-- Laporan Produksi & Green Waste -->
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold text-slate-900 text-sm">Laporan Produksi (MAKE)</h3>
                <span class="p-2 bg-amber-50 text-amber-700 rounded-lg text-xs font-bold">SPK</span>
            </div>
            <div class="space-y-2 text-xs text-slate-600">
                <div class="flex justify-between">
                    <span>Total SPK Diterbitkan:</span>
                    <strong class="text-slate-900">{{ $productionCount }} SPK</strong>
                </div>
                <div class="flex justify-between">
                    <span>Variasi Motif Aktif:</span>
                    <strong class="text-slate-900">{{ $products->count() }} motif</strong>
                </div>
                <div class="flex justify-between">
                    <span>Item Bahan Baku:</span>
                    <strong class="text-slate-900">{{ $materials->count() }} jenis</strong>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('production.index') }}" class="text-xs font-semibold text-red-700 hover:text-red-900 flex items-center gap-1">
                    Buka Log Produksi &rarr;
                </a>
            </div>
        </div>

    </div>

    <!-- Inventory Valuation Report Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100">
            <h3 class="font-bold text-slate-900 text-sm">Valuasi Nilai Persediaan Kain Batik Siap Jual</h3>
            <p class="text-xs text-slate-500">Estimasi aset barang dagang berdasarkan HPP vs potensi omzet harga jual</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Kode & Nama Batik</th>
                        <th class="py-3 px-4">Stok Fisik</th>
                        <th class="py-3 px-4">HPP per Lembar</th>
                        <th class="py-3 px-4">Total Aset Modal</th>
                        <th class="py-3 px-4">Harga Jual per Lembar</th>
                        <th class="py-3 px-4">Potensi Omzet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @php
                        $grandCost = 0;
                        $grandRevenue = 0;
                    @endphp
                    @foreach ($products as $p)
                        @php
                            $cost = $p->stock * $p->cost_price;
                            $rev = $p->stock * $p->selling_price;
                            $grandCost += $cost;
                            $grandRevenue += $rev;
                        @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-bold text-slate-900">{{ $p->name }} ({{ $p->motif_type }})</td>
                            <td class="py-3 px-4">{{ $p->stock }} lembar</td>
                            <td class="py-3 px-4">Rp {{ number_format($p->cost_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 font-semibold text-rose-700">Rp {{ number_format($cost, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($p->selling_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 font-bold text-emerald-700">Rp {{ number_format($rev, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-slate-50/80 font-bold text-slate-900">
                        <td class="py-3 px-4">TOTAL KESELURUHAN</td>
                        <td class="py-3 px-4">{{ $products->sum('stock') }} lembar</td>
                        <td class="py-3 px-4">-</td>
                        <td class="py-3 px-4 text-rose-800">Rp {{ number_format($grandCost, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">-</td>
                        <td class="py-3 px-4 text-emerald-800">Rp {{ number_format($grandRevenue, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

