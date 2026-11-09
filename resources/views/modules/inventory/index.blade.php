@extends('layouts.app')

@section('title', 'Persediaan & Gudang')
@section('header_title', 'Persediaan & Manajemen Pergudangan')
@section('header_subtitle', 'Monitoring stok fisik, kartu mutasi barang masuk/keluar, dan penyesuaian stok opname')

@section('content')
<div class="space-y-6">

    <!-- Stock Adjustment Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Penyesuaian Stok Fisik (Stock Opname)</h3>
                <p class="text-xs text-slate-500">Catat penyesuaian stok opname, limbah potongan, atau mutasi gudang</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-indigo-700 hover:bg-indigo-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Catat Mutasi / Opname'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('inventory.adjust') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tipe Item</label>
                    <select name="item_type" x-model="itemType" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="raw_material">Bahan Baku (Mori/Malam)</option>
                        <option value="product">Produk Batik Jadi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Item</label>
                    <select name="item_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <optgroup label="Bahan Baku">
                            @foreach ($rawMaterials as $rm)
                                <option value="{{ $rm->id }}">{{ $rm->name }} (Sisa: {{ $rm->stock }} {{ $rm->unit }})</option>
                            @endforeach
                        </optgroup>
                        <optgroup label="Produk Batik">
                            @foreach ($products as $pr)
                                <option value="{{ $pr->id }}">{{ $pr->name }} (Sisa: {{ $pr->stock }} pcs)</option>
                            @endforeach
                        </optgroup>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis Mutasi</label>
                    <select name="movement_type" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="adjustment">Penyesuaian Opname (Adjustment)</option>
                        <option value="in">Barang Masuk (In)</option>
                        <option value="out">Barang Keluar (Out)</option>
                        <option value="waste">Limbah / Rusak (Waste)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah</label>
                    <input type="number" step="0.1" name="quantity" value="1" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div class="lg:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan / Alasan Mutasi</label>
                    <input type="text" name="notes" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Hasil perhitungan fisik berkala gudang Bangkalan...">
                </div>
                <div class="lg:col-span-4">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Penyesuaian Stok
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Movement History Cards -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Riwayat Mutasi & Pergerakan Barang (Kartu Stok)</h3>
                <p class="text-xs text-slate-500">Log audit trail seluruh pergerakan persediaan gudang</p>
            </div>
            <span class="text-xs bg-slate-100 px-2.5 py-1 rounded-md text-slate-600 font-medium">Gudang Utama Bangkalan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Waktu</th>
                        <th class="py-3 px-4">Tipe Mutasi</th>
                        <th class="py-3 px-4">Tipe Barang & ID</th>
                        <th class="py-3 px-4">Jumlah Volume</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4">Operator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($movements as $m)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 text-slate-500">{{ $m->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                    {{ $m->movement_type === 'in' ? 'bg-emerald-50 text-emerald-700' : ($m->movement_type === 'out' ? 'bg-sky-50 text-sky-700' : 'bg-amber-50 text-amber-700') }}">
                                    {{ $m->movement_type }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-medium">{{ ucfirst(str_replace('_', ' ', $m->item_type)) }} #{{ $m->item_id }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">{{ number_format($m->quantity, 2) }}</td>
                            <td class="py-3 px-4 text-slate-500">{{ $m->notes }}</td>
                            <td class="py-3 px-4 text-slate-400">{{ $m->user?->name ?? 'Sistem' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada mutasi stok tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

