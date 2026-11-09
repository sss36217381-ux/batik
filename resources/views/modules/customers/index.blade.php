@extends('layouts.app')

@section('title', 'Data Pelanggan')
@section('header_title', 'Data Pelanggan (Customer)')
@section('header_subtitle', 'Pengelolaan database pembeli retail, butik grosir, dan reseller Batik Madura')

@section('content')
<div class="space-y-6">

    <!-- Add Customer Form -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Database Pelanggan</h3>
                <p class="text-xs text-slate-500">Mencakup pembeli eceran hingga galeri butik grosir</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-sky-700 hover:bg-sky-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Tambah Pelanggan Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('customers.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kode Pelanggan</label>
                    <input type="text" name="code" value="CUST-{{ rand(100, 999) }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs font-mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap / Butik</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Ibu Ratna Dewi / Galeri Etnik">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Pelanggan</label>
                    <select name="customer_type" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="retail">Eceran (Retail)</option>
                        <option value="wholesale">Grosir / Butik Galeri (Wholesale)</option>
                        <option value="reseller">Reseller / Dropshipper</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">No. WhatsApp</label>
                    <input type="text" name="phone" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="08123456789">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="pelanggan@mail.com">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Domisili / Kirim</label>
                    <input type="text" name="address" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Surabaya, Jawa Timur">
                </div>
                <div class="lg:col-span-3">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Pelanggan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Customer Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Kode & Nama Pelanggan</th>
                        <th class="py-3 px-4">Tipe</th>
                        <th class="py-3 px-4">Kontak</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4">Total Belanja</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-mono text-[10px] text-slate-400 block">{{ $customer->code }}</span>
                                <span class="font-bold">{{ $customer->name }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold uppercase
                                    {{ $customer->customer_type === 'wholesale' ? 'bg-purple-50 text-purple-700 border border-purple-200' : ($customer->customer_type === 'reseller' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                    {{ $customer->customer_type }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div>{{ $customer->phone ?? '-' }}</div>
                                <div class="text-[11px] text-slate-400">{{ $customer->email ?? '' }}</div>
                            </td>
                            <td class="py-3 px-4 text-slate-500 max-w-xs truncate">{{ $customer->address ?? '-' }}</td>
                            <td class="py-3 px-4 font-semibold">{{ $customer->sales_count }} transaksi</td>
                            <td class="py-3 px-4 text-right">
                                <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Hapus pelanggan ini?')" class="inline">
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
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada data pelanggan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

