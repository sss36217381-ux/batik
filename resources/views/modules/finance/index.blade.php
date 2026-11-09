@extends('layouts.app')

@section('title', 'Keuangan & Laba Rugi')
@section('header_title', 'Keuangan & Laporan Laba Rugi')
@section('header_subtitle', 'Analisis penerimaan penjualan, beban bahan baku, biaya operasional IPAL & laba bersih')

@section('content')
<div class="space-y-6">

    <!-- Financial Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-2">Pendapatan Penjualan</span>
            <p class="text-xl font-bold text-emerald-700">Rp {{ number_format($salesRevenue, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Omzet penjualan batik</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-2">Harga Pokok (Bahan)</span>
            <p class="text-xl font-bold text-rose-700">Rp {{ number_format($purchaseCost, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Pengadaan mori & malam</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block mb-2">Biaya Operasional</span>
            <p class="text-xl font-bold text-amber-700">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-400 mt-1">Listrik, upah, pengolahan limbah</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs bg-gradient-to-br from-slate-900 to-slate-800 text-white">
            <span class="text-xs font-semibold text-slate-300 uppercase tracking-wider block mb-2">Laba Bersih Estimasi</span>
            <p class="text-xl font-black text-amber-400">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
            <p class="text-[11px] text-slate-300 mt-1">Laba kotor dikurangi biaya beban</p>
        </div>
    </div>

    <!-- Record Expense Form -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Pencatatan Biaya Pengeluaran (Beban Operasional)</h3>
                <p class="text-xs text-slate-500">Mencakup pembiayaan instalasi pengolahan air limbah (IPAL) & upah canting</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Catat Pengeluaran Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('finance.expense.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori Biaya</label>
                    <select name="category" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="pengolahan_limbah_ipal">Pengolahan Air Limbah / IPAL (Green)</option>
                        <option value="gaji_pengrajin">Upah Perajin Batik Canting</option>
                        <option value="utilitas_listrik_air">Utilitas Listrik & Pompa Air</option>
                        <option value="pemeliharaan_alat">Pemeliharaan Kompor & Wajan Malam</option>
                        <option value="operasional">Operasional Toko & Galeri</option>
                        <option value="lain_lain">Lain-lain</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Nominal (Rp)</label>
                    <input type="number" step="1000" name="amount" value="150000" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Transaksi</label>
                    <input type="date" name="expense_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Keterangan Biaya</label>
                    <input type="text" name="description" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Filter arang aktif bak IPAL...">
                </div>
                <div class="lg:col-span-4">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Beban Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm">Riwayat Beban Pengeluaran Operasional</h3>
            <span class="text-xs text-slate-500">Total Tercatat: {{ $expenses->count() }} transaksi</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">No. Pengeluaran</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4">Kategori Biaya</th>
                        <th class="py-3 px-4">Keterangan</th>
                        <th class="py-3 px-4">Nominal</th>
                        <th class="py-3 px-4">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($expenses as $exp)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">{{ $exp->expense_number }}</td>
                            <td class="py-3 px-4 text-slate-500">{{ $exp->expense_date->format('d/m/Y') }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-800">
                                    {{ ucfirst(str_replace('_', ' ', $exp->category)) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $exp->description }}</td>
                            <td class="py-3 px-4 font-bold text-rose-700">Rp {{ number_format($exp->amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-slate-400">{{ $exp->user->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada catatan beban pengeluaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

