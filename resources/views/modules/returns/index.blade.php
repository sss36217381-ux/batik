@extends('layouts.app')

@section('title', 'Retur Barang')
@section('header_title', 'Manajemen Retur Produk & Bahan (RETURN)')
@section('header_subtitle', 'Pengelolaan klaim cacat motif, luntur warna, serta disposisi perbaikan produk')

@section('content')
<div class="space-y-6">

    <!-- Add Return Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Pencatatan Klaim Retur Barang</h3>
                <p class="text-xs text-slate-500">Mendukung metrik Green SCOR RETURN (Defect Handling & Recycle)</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-rose-700 hover:bg-rose-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Ajukan Klaim Retur Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('returns.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tipe Retur</label>
                    <select name="return_type" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="sale_return">Retur Penjualan (Dari Pelanggan / Butik)</option>
                        <option value="purchase_return">Retur Pembelian (Ke Pemasok Mori/Malam)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Pihak (Pelanggan/Pemasok)</label>
                    <input type="text" name="party_name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Ibu Ratna / CV Sumber Sutra">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Pengajuan Retur</label>
                    <input type="date" name="return_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tindakan Penanganan</label>
                    <select name="handling_action" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="replace">Ganti Produk Baru (Replace)</option>
                        <option value="repair">Perbaiki Cantingan / Celup Ulang (Repair)</option>
                        <option value="refund">Kembalikan Dana (Refund)</option>
                        <option value="dispose">Daur Ulang / Dibuang (Dispose)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Estimasi Nilai Barang (Rp)</label>
                    <input type="number" step="1000" name="total_amount" value="350000" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alasan Retur / Jenis Cacat</label>
                    <input type="text" name="reason" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Tetesan lilin malam tembus / serat kain cacat">
                </div>
                <div class="lg:col-span-3">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Berita Acara Retur
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Returns Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">No. Retur & Tanggal</th>
                        <th class="py-3 px-4">Tipe & Pihak Terkait</th>
                        <th class="py-3 px-4">Alasan Cacat</th>
                        <th class="py-3 px-4">Tindakan</th>
                        <th class="py-3 px-4">Nilai Barang</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($returns as $ret)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-bold text-slate-900 font-mono">{{ $ret->return_number }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $ret->return_date->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-semibold">{{ $ret->party_name }}</span>
                                <span class="text-[10px] text-slate-400 block uppercase">{{ str_replace('_', ' ', $ret->return_type) }}</span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $ret->reason }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700 uppercase">
                                    {{ $ret->handling_action }}
                                </span>
                            </td>
                            <td class="py-3 px-4 font-bold text-slate-900">Rp {{ number_format($ret->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700 uppercase">
                                    {{ $ret->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Tidak ada pengajuan retur barang (Kualitas produksi terkendali).</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($returns->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $returns->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
