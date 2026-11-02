@extends('layouts.app')

@section('title', 'Penjualan Batik (POS)')
@section('header_title', 'Kasir & Transaksi Penjualan Batik (POS)')
@section('header_subtitle', 'Pencatatan faktur penjualan kain batik tulis, metode pembayaran & pengurangan stok')

@section('content')
<div class="space-y-6">

    <!-- Add Sale Form Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Faktur Penjualan Baru (POS Checkout)</h3>
                <p class="text-xs text-slate-500">Stok kain batik otomatis berkurang seketika transaksi tersimpan</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-red-700 hover:bg-red-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Buat Faktur Penjualan Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('sales.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Pelanggan</label>
                    <select name="customer_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        @foreach ($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ ucfirst($c->customer_type) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Produk Batik</label>
                    <select name="product_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        @foreach ($products as $pr)
                            <option value="{{ $pr->id }}">{{ $pr->name }} (Rp {{ number_format($pr->selling_price, 0) }} - Stok: {{ $pr->stock }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Lembar Kain</label>
                    <input type="number" name="quantity" value="1" min="1" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Metode Pembayaran</label>
                    <select name="payment_method" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="cash">Tunai (Cash)</option>
                        <option value="transfer_bank">Transfer Bank (BCA / Mandiri / Jatim)</option>
                        <option value="qris">QRIS Standar Nasional</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Potongan / Diskon (Rp)</label>
                    <input type="number" step="1000" name="discount_amount" value="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                    <input type="text" name="notes" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Kado kemasan besek batik...">
                </div>
                <div class="lg:col-span-3">
                    <button type="submit" class="w-full py-2.5 bg-red-700 hover:bg-red-800 text-white font-bold text-xs rounded-xl shadow">
                        Proses Checkout & Potong Stok Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">No. Invoice & Tanggal</th>
                        <th class="py-3 px-4">Pelanggan</th>
                        <th class="py-3 px-4">Kain Batik Terjual</th>
                        <th class="py-3 px-4">Total Pembayaran</th>
                        <th class="py-3 px-4">Metode & Status</th>
                        <th class="py-3 px-4">Kasir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($sales as $sale)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-bold text-slate-900 font-mono">{{ $sale->invoice_number }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $sale->sale_date->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-3 px-4 font-semibold">{{ $sale->customer->name }}</td>
                            <td class="py-3 px-4">
                                @foreach ($sale->details as $d)
                                    <div>{{ $d->product->name }} ({{ $d->quantity }} pcs)</div>
                                @endforeach
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-900">
                                Rp {{ number_format($sale->grand_total, 0, ',', '.') }}
                                @if($sale->discount_amount > 0)
                                    <span class="text-[10px] text-amber-600 block font-normal">Diskon: Rp {{ number_format($sale->discount_amount, 0) }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ strtoupper($sale->payment_method) }} &bull; Lunas
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">{{ $sale->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada transaksi penjualan kasir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($sales->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $sales->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
