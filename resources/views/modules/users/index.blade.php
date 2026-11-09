@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('header_title', 'Manajemen Pengguna & Hak Akses')
@section('header_subtitle', 'Kelola akun staf UMKM berdasarkan role (Admin, Pemilik, Gudang, Produksi, Pembelian, Penjualan)')

@section('content')
<div class="space-y-6">

    <!-- Add User Modal / Form Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Daftar Akun Pengguna</h3>
                <p class="text-xs text-slate-500">Total: {{ $users->total() }} akun terdaftar</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-red-700 hover:bg-red-800 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Tambah Pengguna Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('users.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Misal: Mochammad Choirul">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="choirul@batikmadura.id">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Minimal 6 karakter">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Peran / Role</label>
                    <select name="role_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        @foreach ($roles as $r)
                            <option value="{{ $r->id }}">{{ $r->display_name }} ({{ $r->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nomor Telepon/WA</label>
                    <input type="text" name="phone" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="081234567890">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Nama & Email</th>
                        <th class="py-3 px-4">Peran (Role)</th>
                        <th class="py-3 px-4">Telepon</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <div>{{ $user->name }}</div>
                                <div class="text-[11px] text-slate-400 font-normal">{{ $user->email }}</div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $user->role?->display_name ?? 'Tanpa Role' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ $user->phone ?? '-' }}</td>
                            <td class="py-3 px-4">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-50 text-rose-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('users.toggle', $user) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs font-semibold {{ $user->is_active ? 'text-amber-700 hover:text-amber-900' : 'text-emerald-700 hover:text-emerald-900' }}">
                                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">Sesi Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">Tidak ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

