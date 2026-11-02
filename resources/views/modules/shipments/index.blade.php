@extends('layouts.app')

@section('title', 'Pengiriman Pesanan')
@section('header_title', 'Manajemen Pengiriman Pesanan (DELIVER)')
@section('header_subtitle', 'Pelacakan ekspedisi butik pelanggan, nomor resi & ketepatan waktu pengiriman (On-Time Delivery)')

@section('content')
<div class="space-y-6">

    <!-- Add Shipment Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Input Surat Jalan / Pengiriman Ekspedisi</h3>
                <p class="text-xs text-slate-500">Mendukung metrik Green SCOR DELIVER (On-Time Delivery Rate)</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Buat Surat Jalan Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('shipments.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Transaksi Penjualan</label>
                    <select name="sale_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        @foreach ($pendingSales as $s)
                            <option value="{{ $s->id }}">{{ $s->invoice_number }} - {{ $s->customer->name }} (Rp {{ number_format($s->grand_total, 0) }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Jasa Kurir / Ekspedisi</label>
                    <input type="text" name="courier_name" value="Kurir Toko Bangkalan" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Resi / Pelacakan</label>
                    <input type="text" name="tracking_number" value="RESI-{{ rand(100000, 999999) }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Dikirim</label>
                    <input type="date" name="shipping_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Tujuan Pengiriman</label>
                    <input type="text" name="shipping_address" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Jl. Basuki Rahmat No. 88, Surabaya">
                </div>
                <div class="lg:col-span-3">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Terbitkan Resi & Kirim Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Shipments Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">No. Invoice & Resi</th>
                        <th class="py-3 px-4">Penerima & Alamat</th>
                        <th class="py-3 px-4">Kurir Ekspedisi</th>
                        <th class="py-3 px-4">Tanggal Kirim</th>
                        <th class="py-3 px-4">Metrik On-Time</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($shipments as $ship)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-bold text-slate-900 font-mono">{{ $ship->sale->invoice_number }}</span>
                                <span class="text-[11px] text-blue-700 block font-mono">{{ $ship->tracking_number ?? 'Internal' }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-semibold">{{ $ship->sale->customer->name }}</span>
                                <span class="text-[11px] text-slate-400 block truncate max-w-xs">{{ $ship->shipping_address }}</span>
                            </td>
                            <td class="py-3 px-4">{{ $ship->courier_name }}</td>
                            <td class="py-3 px-4 text-slate-500">{{ $ship->shipping_date->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                    ✓ Tepat Waktu
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-blue-50 text-blue-700 uppercase">
                                    {{ $ship->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada data pengiriman aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($shipments->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
