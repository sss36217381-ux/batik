<?php

namespace App\Http\Controllers;

use App\Models\GreenScorMetric;
use App\Models\GreenScorResult;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GreenSupplyChainController extends Controller
{
    public function index(): View
    {
        $metrics = GreenScorMetric::orderBy('dimension')->get();
        $results = GreenScorResult::latest()->take(5)->get();
        $latestResult = GreenScorResult::latest()->first();

        // Group by dimension
        $byDimension = $metrics->groupBy('dimension');

        $scores = [
            'PLAN' => $metrics->where('dimension', 'PLAN')->sum('final_score'),
            'SOURCE' => $metrics->where('dimension', 'SOURCE')->sum('final_score'),
            'MAKE' => $metrics->where('dimension', 'MAKE')->sum('final_score'),
            'DELIVER' => $metrics->where('dimension', 'DELIVER')->sum('final_score'),
            'RETURN' => $metrics->where('dimension', 'RETURN')->sum('final_score'),
        ];

        $currentTotalIndex = array_sum($scores);

        return view('modules.green_supply_chain.index', compact(
            'metrics',
            'results',
            'latestResult',
            'byDimension',
            'scores',
            'currentTotalIndex'
        ));
    }

    public function updateMetric(Request $request, GreenScorMetric $metric): RedirectResponse
    {
        $validated = $request->validate([
            'actual_value' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'numeric', 'between:0,1'],
        ]);

        // Snorm De Boer Normalization
        // S = ((Actual - Min) / (Max - Min)) * 100
        // Sederhana: rasio actual terhadap target (dinormalisasi 0 - 100)
        $actual = (float) $validated['actual_value'];
        $target = (float) $metric->target_value;
        $weight = (float) $validated['weight'];

        // If lower is better (e.g., waste, water, returns)
        if (in_array($metric->code, ['MK-01', 'RT-01'])) {
            $normalized = $actual > 0 ? min(100, max(0, ($target / $actual) * 100)) : 100;
        } else {
            $normalized = $target > 0 ? min(100, max(0, ($actual / $target) * 100)) : 0;
        }

        $finalScore = ($normalized * $weight);

        $metric->update([
            'actual_value' => $actual,
            'weight' => $weight,
            'normalized_score' => round($normalized, 2),
            'final_score' => round($finalScore, 2),
        ]);

        return redirect()->route('green-supply-chain.index')
            ->with('success', "Indikator [{$metric->code}] {$metric->metric_name} berhasil diperbarui.");
    }

    public function recalculate(Request $request): RedirectResponse
    {
        $metrics = GreenScorMetric::all();

        $planScore = $metrics->where('dimension', 'PLAN')->sum('final_score');
        $sourceScore = $metrics->where('dimension', 'SOURCE')->sum('final_score');
        $makeScore = $metrics->where('dimension', 'MAKE')->sum('final_score');
        $deliverScore = $metrics->where('dimension', 'DELIVER')->sum('final_score');
        $returnScore = $metrics->where('dimension', 'RETURN')->sum('final_score');

        $total = $planScore + $sourceScore + $makeScore + $deliverScore + $returnScore;

        $category = match (true) {
            $total >= 90 => 'Excellent',
            $total >= 70 => 'Good',
            $total >= 50 => 'Average',
            $total >= 40 => 'Marginal',
            default => 'Poor',
        };

        $result = GreenScorResult::create([
            'evaluation_period' => 'Evaluasi ' . now()->format('F Y'),
            'evaluation_date' => now()->toDateString(),
            'plan_score' => $planScore,
            'source_score' => $sourceScore,
            'make_score' => $makeScore,
            'deliver_score' => $deliverScore,
            'return_score' => $returnScore,
            'total_index' => $total,
            'category' => $category,
            'notes' => 'Kalkulasi indeks komprehensif Green SCOR berdasarkan bobot ANP dan data operasional terkini UMKM Batik Madura.',
            'evaluated_by' => auth()->user()->name,
        ]);

        return redirect()->route('green-supply-chain.index')
            ->with('success', "Indeks Green Supply Chain berhasil dihitung ulang! Skor: {$result->total_index} (Kategori: {$result->category}).");
    }
}
