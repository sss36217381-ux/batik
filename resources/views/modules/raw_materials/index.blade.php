@extends('layouts.app')

@section('title', 'Bahan Baku Batik')
@section('header_title', 'Manajemen Bahan Baku & Green Materials')
@section('header_subtitle', 'Kain mori, malam/lilin canting, pewarna alami (Indigofera/Tingi) & kimia pendukung')

@section('content')
<div class="space-y-6">

    <!-- Add Raw Material Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Persediaan Bahan Baku Produksi</h3>
                <p class="text-xs text-slate-500">Mendukung monitoring bahan ramah lingkungan untuk Green SCOR (SOURCE & MAKE)</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Tambah Bahan Baku Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('raw-materials.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Bahan</label>
                    <input type="text" name="code" value="RAW-{{ rand(10, 99) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Bahan Baku</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Mori Primissima / Malam Tawon">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Bahan</label>
                    <select name="category" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="kain">Kain Mori / Sutra</option>
                        <option value="malam">Lilin Malam Batik</option>
                        <option value="pewarna_alami">Pewarna Alami (Green Eco)</option>
                        <option value="pewarna_sintetis">Pewarna Sintetis Reaktif</option>
                        <option value="bahan_pendukung">Bahan Pendukung (Soda Abu/Waterglass)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Satuan Ukur</label>
                    <input type="text" name="unit" value="meter" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="meter / kg / liter">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Stok Awal</label>
                    <input type="number" step="0.1" name="stock" value="50" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Batas Minimum Stok (Reorder Point)</label>
                    <input type="number" step="0.1" name="min_stock" value="10" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Harga Satuan (Rp)</label>
                    <input type="number" step="500" name="unit_price" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="45000">
                </div>
                <div class="flex items-center pt-5">
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_eco_friendly" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="font-bold text-emerald-800">🍃 Bahan Ramah Lingkungan (Green Material)</span>
                    </label>
                </div>
                <div class="lg:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi Tambahan</label>
                    <input type="text" name="description" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Spesifikasi bahan...">
                </div>
                <div class="lg:col-span-4">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Bahan Baku
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Raw Materials Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Kode & Nama Bahan</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Klasifikasi Eco</th>
                        <th class="py-3 px-4">Harga Satuan</th>
                        <th class="py-3 px-4">Stok Tersedia</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($rawMaterials as $mat)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-mono text-[10px] text-slate-400 block">{{ $mat->code }}</span>
                                <span class="font-bold">{{ $mat->name }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-700">
                                    {{ ucfirst(str_replace('_', ' ', $mat->category)) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($mat->is_eco_friendly)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        🍃 Eco-Friendly
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600">
                                        Sintetis / Standar
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4">Rp {{ number_format($mat->unit_price, 0, ',', '.') }} / {{ $mat->unit }}</td>
                            <td class="py-3 px-4">
                                @if($mat->isLowStock())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        ⚠️ Menipis: {{ number_format($mat->stock, 2) }} {{ $mat->unit }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">
                                        {{ number_format($mat->stock, 2) }} {{ $mat->unit }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <form method="POST" action="{{ route('raw-materials.destroy', $mat) }}" onsubmit="return confirm('Hapus bahan baku ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-semibold text-rose-600 hover:text-rose-800">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada bahan baku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rawMaterials->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $rawMaterials->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

