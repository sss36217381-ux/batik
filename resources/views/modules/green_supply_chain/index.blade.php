@extends('layouts.app')

@section('title', 'Green Supply Chain Analytics')
@section('header_title', 'Green Supply Chain Management (GSCOR & ANP)')
@section('header_subtitle', 'Model Kinerja Rantai Pasok Hijau Berdasarkan 5 Pilar: PLAN, SOURCE, MAKE, DELIVER, RETURN')

@section('content')
<div class="space-y-6">

    <!-- Overview Banner with Research Context -->
    <div class="bg-gradient-to-r from-emerald-950 via-teal-900 to-slate-900 border border-emerald-700/60 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
        <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div class="max-w-2xl">
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wide bg-emerald-400 text-slate-950">
                        Riset Terapan GSCOR
                    </span>
                    <span class="text-xs text-emerald-300 font-medium">Model ANP (Analytic Network Process)</span>
                </div>
                <h2 class="text-2xl font-black tracking-tight">Kinerja Green SCOR: {{ number_format($currentTotalIndex, 2) }} / 100</h2>
                <p class="text-xs text-slate-200 mt-1 leading-relaxed">
                    Evaluasi berbasis 5 proses inti: <strong>PLAN</strong> (Perencanaan ramah lingkungan), <strong>SOURCE</strong> (Pengadaan green supplier), 
                    <strong>MAKE</strong> (Konsumsi air & reduksi limbah malam), <strong>DELIVER</strong> (Ketepatan waktu distribusi), dan <strong>RETURN</strong> (Penanganan produk cacat & daur ulang).
                </p>
                <div class="mt-3 inline-flex items-center gap-2 bg-emerald-900/60 border border-emerald-700/50 px-3 py-1.5 rounded-xl text-[11px] text-emerald-200">
                    <span>💡 Catatan Referensi Artikel:</span>
                    <span>Penelitian terdahulu menghasilkan indeks <strong>65,5225 (Kategori Average)</strong>. Hasil sistem ini dihitung dinamis sesuai input data UMKM.</span>
                </div>
            </div>

            <!-- Recalculate Trigger Card -->
            <div class="bg-slate-900/90 border border-emerald-600/40 p-4 rounded-xl text-center shrink-0 w-full lg:w-64">
                <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider block">Kategori Mutu</span>
                <p class="text-2xl font-black text-emerald-400 my-1">
                    {{ $latestResult->category ?? ($currentTotalIndex >= 70 ? 'Good' : ($currentTotalIndex >= 50 ? 'Average' : 'Marginal')) }}
                </p>
                <p class="text-[11px] text-slate-400 mb-3">Total Bobot: 1.0000</p>
                <form method="POST" action="{{ route('green-supply-chain.recalculate') }}">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs rounded-lg shadow transition">
                        ⚡ Hitung Ulang Indeks
                    </button>
                </form>
            </div>
        </div>

        <!-- 5 Dimension Breakdown Progress Bars -->
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-3 mt-6 pt-5 border-t border-emerald-800/60">
            @foreach (['PLAN', 'SOURCE', 'MAKE', 'DELIVER', 'RETURN'] as $dim)
                <div class="bg-slate-900/70 p-3 rounded-xl border border-emerald-900/50">
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="font-bold text-slate-300">{{ $dim }}</span>
                        <span class="font-extrabold text-emerald-400">{{ number_format($scores[$dim] ?? 0, 2) }}</span>
                    </div>
                    <div class="w-full bg-slate-800 h-2 rounded-full overflow-hidden">
                        <div class="bg-emerald-500 h-full rounded-full" style="width: {{ min(100, (($scores[$dim] ?? 0) / 20) * 100) }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Indicator Adjustment Table & ANP Weight Management -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="font-bold text-slate-900 text-sm">Daftar Indikator Kinerja & Penyesuaian Bobot ANP</h3>
                <p class="text-xs text-slate-500">Bobot dapat disesuaikan (tidak permanen hardcoded) sesuai karakteristik dan prioritas UMKM</p>
            </div>
            <span class="text-xs bg-emerald-50 text-emerald-800 font-semibold px-2.5 py-1 rounded-md border border-emerald-200">
                Total {{ $metrics->count() }} Indikator Terdefinisi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Kode & Dimensi</th>
                        <th class="py-3 px-4">Nama Indikator Kinerja</th>
                        <th class="py-3 px-4">Target Acuan</th>
                        <th class="py-3 px-4">Nilai Riil (Aktual)</th>
                        <th class="py-3 px-4">Bobot ANP</th>
                        <th class="py-3 px-4">Skor Normalisasi (0-100)</th>
                        <th class="py-3 px-4">Skor Akhir</th>
                        <th class="py-3 px-4 text-right">Perbarui</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @foreach ($metrics as $metric)
                        <tr class="hover:bg-slate-50/50">
                            <form method="POST" action="{{ route('green-supply-chain.update', $metric) }}">
                                @csrf
                                @method('PATCH')
                                <td class="py-3 px-4 font-medium text-slate-900">
                                    <span class="font-bold font-mono text-[11px] text-slate-800 block">{{ $metric->code }}</span>
                                    <span class="text-[10px] font-semibold uppercase px-1.5 py-0.5 rounded 
                                        {{ $metric->dimension === 'MAKE' ? 'bg-amber-100 text-amber-800' : ($metric->dimension === 'SOURCE' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700') }}">
                                        {{ $metric->dimension }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 max-w-xs">
                                    <span class="font-bold text-slate-900 block">{{ $metric->metric_name }}</span>
                                    <span class="text-[11px] text-slate-500">{{ $metric->description }}</span>
                                </td>
                                <td class="py-3 px-4 font-semibold text-slate-700">
                                    {{ $metric->target_value }} {{ $metric->unit }}
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-1">
                                        <input type="number" step="0.01" name="actual_value" value="{{ $metric->actual_value }}" required
                                               class="w-20 px-2 py-1 border border-slate-300 rounded text-xs text-right font-bold text-slate-900">
                                        <span class="text-slate-500 text-[11px]">{{ $metric->unit }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <input type="number" step="0.001" min="0" max="1" name="weight" value="{{ $metric->weight }}" required
                                           class="w-16 px-2 py-1 border border-slate-300 rounded text-xs text-right font-mono text-slate-900">
                                </td>
                                <td class="py-3 px-4">
                                    <span class="font-semibold text-slate-900">{{ number_format($metric->normalized_score, 1) }}</span>
                                </td>
                                <td class="py-3 px-4 font-extrabold text-emerald-700">
                                    {{ number_format($metric->final_score, 2) }}
                                </td>
                                <td class="py-3 px-4 text-right">
                                    <button type="submit" class="px-2.5 py-1 bg-slate-900 hover:bg-slate-800 text-white rounded font-semibold text-[11px] shadow transition">
                                        Simpan
                                    </button>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Historical GSCOR Audits -->
    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900 text-sm">Riwayat Evaluasi Kinerja Rantai Pasok Hijau</h3>
            <span class="text-xs text-slate-500">Audit berkala keberlanjutan UMKM</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase font-semibold">
                    <tr>
                        <th class="py-3 px-4">Periode & Tanggal</th>
                        <th class="py-3 px-4">PLAN</th>
                        <th class="py-3 px-4">SOURCE</th>
                        <th class="py-3 px-4">MAKE</th>
                        <th class="py-3 px-4">DELIVER</th>
                        <th class="py-3 px-4">RETURN</th>
                        <th class="py-3 px-4">Total Indeks</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Evaluator</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($results as $res)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3 px-4 font-medium text-slate-900">
                                <span class="font-bold">{{ $res->evaluation_period }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $res->evaluation_date->format('d/m/Y') }}</span>
                            </td>
                            <td class="py-3 px-4">{{ number_format($res->plan_score, 2) }}</td>
                            <td class="py-3 px-4">{{ number_format($res->source_score, 2) }}</td>
                            <td class="py-3 px-4 text-amber-700 font-semibold">{{ number_format($res->make_score, 2) }}</td>
                            <td class="py-3 px-4">{{ number_format($res->deliver_score, 2) }}</td>
                            <td class="py-3 px-4">{{ number_format($res->return_score, 2) }}</td>
                            <td class="py-3 px-4 font-black text-emerald-700 text-sm">{{ number_format($res->total_index, 2) }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                    {{ $res->category === 'Good' || $res->category === 'Excellent' ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                    {{ $res->category }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-500">{{ $res->evaluated_by }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-6 text-center text-slate-400">Belum ada riwayat evaluasi berkala.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

