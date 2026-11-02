@extends('layouts.app')

@section('title', 'Produksi Batik')
@section('header_title', 'Perencanaan & Proses Produksi Batik (MAKE)')
@section('header_subtitle', 'Alur membatik, monitoring air pelorotan, daur ulang lilin malam & estimasi limbah')

@section('content')
<div class="space-y-6">

    <!-- Add Production Order Accordion -->
    <div x-data="{ open: false }" class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Order Perencanaan Produksi (SPK Membatik)</h3>
                <p class="text-xs text-slate-500">Mencakup pemantauan konsumsi air dan penanganan limbah malam (GSCOR MAKE)</p>
            </div>
            <button @click="open = !open" 
                    class="px-3.5 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2">
                <span x-text="open ? 'Tutup Formulir' : '+ Mulai Order Produksi Baru'"></span>
            </button>
        </div>

        <div x-show="open" x-cloak class="mt-4 pt-4 border-t border-slate-100">
            <form method="POST" action="{{ route('production.store') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Target Motif Batik</label>
                    <select name="target_product_id" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        @foreach ($products as $pr)
                            <option value="{{ $pr->id }}">{{ $pr->name }} ({{ $pr->motif_type }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Rencana Jumlah (Lembar)</label>
                    <input type="number" name="planned_quantity" value="5" min="1" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tanggal Mulai Produksi</label>
                    <input type="date" name="start_date" value="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Tahapan Produksi Awal</label>
                    <select name="stage" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-white">
                        <option value="pola_desain">1. Gambar Pola Kain (Desain)</option>
                        <option value="canting_malam">2. Mencanting Malam Panas</option>
                        <option value="pewarnaan">3. Pewarnaan (Alami/Sintetis)</option>
                        <option value="pelorotan">4. Pelorotan (Air Mendidih)</option>
                        <option value="penjemuran">5. Penjemuran Udara Alami</option>
                        <option value="finishing">6. Finishing & Kontrol Kualitas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Estimasi Air (Liter) [GSCOR]</label>
                    <input type="number" step="0.5" name="water_usage_liters" value="45.0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Estimasi Limbah Malam (kg)</label>
                    <input type="number" step="0.1" name="waste_generated_kg" value="2.5" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Target Daur Ulang Malam (kg)</label>
                    <input type="number" step="0.1" name="recycled_wax_kg" value="1.8" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan</label>
                    <input type="text" name="notes" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs" placeholder="Pencelupan gentongan khusus...">
                </div>
                <div class="lg:col-span-4">
                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg shadow">
                        Terbitkan SPK Produksi Batik
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Production Orders Table -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">No. SPK & Waktu</th>
                        <th class="py-3 px-4">Motif Batik</th>
                        <th class="py-3 px-4">Target Jumlah</th>
                        <th class="py-3 px-4">Tahapan Saat Ini</th>
                        <th class="py-3 px-4">Metrik Green MAKE</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-bold text-slate-900 font-mono">{{ $order->order_number }}</span>
                                <span class="text-[11px] text-slate-400 block">Mulai: {{ $order->start_date->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-3 px-4 font-semibold text-slate-900">{{ $order->product->name }}</td>
                            <td class="py-3 px-4 font-bold">{{ $order->planned_quantity }} lembar</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                    {{ ucfirst(str_replace('_', ' ', $order->stage)) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-[11px]">
                                <div>💧 Air: <strong>{{ number_format($order->water_usage_liters, 1) }} L</strong></div>
                                <div>♻️ Daur Ulang Malam: <strong>{{ number_format($order->recycled_wax_kg, 1) }} kg</strong></div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $order->status === 'completed' ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400">Belum ada order produksi aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="p-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
