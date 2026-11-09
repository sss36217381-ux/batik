@extends('layouts.app')

@section('title', 'Pembelian Bahan Baku')
@section('header_title', 'Pengadaan & Pembelian Bahan (SOURCE)')
@section('header_subtitle', 'Transaksi order pembelian ke pemasok kain mori & lilin malam batik')

@section('content')
<div class="space-y-6">

    <!-- Add Purchase Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Catatan Order Pembelian (PO)</h3>
                <p class="text-xs text-slate-500">Stok bahan baku otomatis bertambah saat pembelian tercatat</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-cyan-700 hover:bg-cyan-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Buat Transaksi Pembelian Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('purchases.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pemasok</label>
                    <select name="supplier_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        @foreach ($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }} {{ $sup->is_eco_certified ? '(🍃 Green)' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Bahan Baku</label>
                    <select name="raw_material_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        @foreach ($rawMaterials as $rm)
                            <option value="{{ $rm->id }}">{{ $rm->name }} (Rp {{ number_format($rm->unit_price, 0) }}/{{ $rm->unit }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Pembelian</label>
                    <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Volume</label>
                    <input type="number" step="0.1" min="0.1" name="quantity" value="10" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Harga Satuan Beli (Rp)</label>
                    <input type="number" step="500" name="unit_price" value="45000" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan</label>
                    <input type="text" name="notes" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Batch pengiriman...">
                </div>
                <div class="lg:col-span-3">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Transaksi Pembelian & Masukkan ke Gudang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Purchases Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">No. PO & Tanggal</th>
                        <th class="py-3 px-4">Pemasok</th>
                        <th class="py-3 px-4">Bahan Baku Dipesan</th>
                        <th class="py-3 px-4">Total Biaya</th>
                        <th class="py-3 px-4">Status & Pembayaran</th>
                        <th class="py-3 px-4">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($purchases as $p)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-bold text-slate-900 font-mono">{{ $p->purchase_number }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $p->purchase_date->format('d M Y') }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-semibold">{{ $p->supplier->name }}</span>
                                @if($p->supplier->is_eco_certified)
                                    <span class="text-[10px] text-emerald-700 block">🍃 Green Supplier</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @foreach ($p->details as $d)
                                    <div>{{ $d->rawMaterial->name }} ({{ number_format($d->quantity, 1) }} {{ $d->rawMaterial->unit }})</div>
                                @endforeach
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-900">
                                Rp {{ number_format($p->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ ucfirst($p->status) }} &bull; {{ ucfirst($p->payment_status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">{{ $p->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada riwayat pembelian bahan baku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($purchases->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $purchases->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

