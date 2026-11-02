@extends('layouts.app')

@section('title', 'Produk Batik Madura')
@section('header_title', 'Master Data Produk Batik Tulis')
@section('header_subtitle', 'Katalog motif Gentongan, Aromanis, Sekar Jagat, Lancor & HPP vs Harga Jual')

@section('content')
<div class="space-y-6">

    <!-- Add Product Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Katalog Produk Batik Siap Jual</h3>
                <p class="text-xs text-slate-500">Mencakup pengelolaan motif, ukuran, stok fisik, dan margin keuntungan</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-red-700 hover:bg-red-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Tambah Motif Batik Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('products.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Produk (SKU)</label>
                    <input type="text" name="code" value="BTK-{{ rand(10, 99) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Produk</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Batik Tulis Gentongan Halus">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jenis / Motif Khas Madura</label>
                    <input type="text" name="motif_type" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Gentongan / Aromanis / Lancor">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Ukuran Kain</label>
                    <input type="text" name="size" value="200 x 115 cm" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">HPP / Modal (Rp)</label>
                    <input type="number" step="1000" name="cost_price" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="350000">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Harga Jual (Rp)</label>
                    <input type="number" step="1000" name="selling_price" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="700000">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Stok Awal</label>
                    <input type="number" name="stock" value="5" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Batas Minimum Stok</label>
                    <input type="number" name="min_stock" value="2" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div class="lg:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Deskripsi & Keunikan Motif</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Kain mori primissima dengan pewarnaan alami rendaman gentong tanah liat..."></textarea>
                </div>
                <div class="lg:col-span-4">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Produk Batik
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Motif & Nama Batik</th>
                        <th class="py-3 px-4">Ukuran</th>
                        <th class="py-3 px-4">HPP (Modal)</th>
                        <th class="py-3 px-4">Harga Jual</th>
                        <th class="py-3 px-4">Margin Laba</th>
                        <th class="py-3 px-4">Stok Fisik</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($products as $prod)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-mono text-[10px] text-slate-400 block">{{ $prod->code }}</span>
                                <span class="font-bold text-slate-900">{{ $prod->name }}</span>
                                <span class="text-[11px] text-amber-700 block font-normal">Motif: {{ $prod->motif_type }}</span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">{{ $prod->size }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($prod->cost_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 font-bold text-slate-900">Rp {{ number_format($prod->selling_price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-emerald-700 font-semibold">
                                Rp {{ number_format($prod->selling_price - $prod->cost_price, 0, ',', '.') }}
                                <span class="text-[10px] text-slate-400 block">({{ $prod->cost_price > 0 ? round((($prod->selling_price - $prod->cost_price) / $prod->cost_price) * 100) : 0 }}%)</span>
                            </td>
                            <td class="py-3 px-4">
                                @if($prod->isLowStock())
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                        ⚠️ Menipis: {{ $prod->stock }} lembar
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">
                                        {{ $prod->stock }} lembar
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                <form method="POST" action="{{ route('products.destroy', $prod) }}" onsubmit="return confirm('Hapus produk batik ini?')" class="inline">
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
                            <td colspan="7" class="py-6 text-center text-slate-400">Belum ada produk batik.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
