@extends('layouts.app')

@section('title', 'Data Pemasok')
@section('header_title', 'Data Pemasok Bahan Baku (SOURCE)')
@section('header_subtitle', 'Pengelolaan vendor kain mori, malam, pewarna alami & evaluasi Green Supplier')

@section('content')
<div class="space-y-6">

    <!-- Add Supplier Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Daftar Pemasok Terdaftar</h3>
                <p class="text-xs text-slate-500">Mendukung klasifikasi pemasok bersertifikasi ramah lingkungan</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Tambah Pemasok Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('suppliers.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Pemasok</label>
                    <input type="text" name="code" value="SUP-{{ rand(100, 999) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Usaha / Pemasok</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="CV / Toko Sumber Tekstil">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kontak Person (PIC)</label>
                    <input type="text" name="contact_person" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Bpk. Rozaq">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">No. Telepon / WhatsApp</label>
                    <input type="text" name="phone" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="08123456789">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="vendor@gmail.com">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Rating Ramah Lingkungan (1-5)</label>
                    <input type="number" step="0.1" min="1" max="5" name="eco_rating" value="4.0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                    <input type="text" name="address" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Desa Tanjungbumi, Bangkalan">
                </div>
                <div class="flex items-center gap-2 pt-4">
                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_eco_certified" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="font-semibold text-emerald-800">Sertifikasi Ramah Lingkungan (Green Supplier)</span>
                    </label>
                </div>
                <div class="lg:col-span-3">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Data Pemasok
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Suppliers Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Kode & Nama Pemasok</th>
                        <th class="py-3 px-4">Kontak Person</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4">Green Status</th>
                        <th class="py-3 px-4">Total Order</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($suppliers as $supplier)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-mono text-[10px] text-slate-400 block">{{ $supplier->code }}</span>
                                <span class="font-bold">{{ $supplier->name }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div>{{ $supplier->contact_person ?? '-' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $supplier->phone ?? $supplier->email ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-4 text-slate-500 max-w-xs truncate">{{ $supplier->address ?? '-' }}</td>
                            <td class="py-3 px-4">
                                @if($supplier->is_eco_certified)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        🍃 Eco-Certified (★ {{ $supplier->eco_rating }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600">
                                        Standar (★ {{ $supplier->eco_rating }})
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-semibold">{{ $supplier->purchases_count }} transaksi</td>
                            <td class="py-3 px-4 text-right">
                                <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" onsubmit="return confirm('Hapus pemasok ini?')" class="inline">
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
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada data pemasok.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($suppliers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $suppliers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

