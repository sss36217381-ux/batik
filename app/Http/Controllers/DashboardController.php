<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\GreenScorMetric;
use App\Models\GreenScorResult;
use App\Models\Product;
use App\Models\ProductionOrder;
use App\Models\Purchase;
use App\Models\RawMaterial;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalSales = Sale::where('status', 'completed')->sum('grand_total');
        $totalPurchases = Purchase::where('status', 'received')->sum('total_amount');

        $totalProducts = Product::count();
        $totalProductStock = Product::sum('stock');
        $lowStockProducts = Product::whereColumn('stock', '<=', 'min_stock')->get();

        $totalRawMaterials = RawMaterial::count();
        $totalMaterialStock = RawMaterial::sum('stock');
        $lowStockMaterials = RawMaterial::whereColumn('stock', '<=', 'min_stock')->get();

        $activeProductions = ProductionOrder::whereIn('status', ['draft', 'in_progress'])->count();
        $completedProductions = ProductionOrder::where('status', 'completed')->count();

        $totalSuppliers = Supplier::count();
        $ecoSuppliers = Supplier::where('is_eco_certified', true)->count();
        $totalCustomers = Customer::count();

        // Green SCOR
        $latestGscorResult = GreenScorResult::latest()->first();
        $gscorMetrics = GreenScorMetric::all();
        $dimensionScores = [
            'PLAN' => GreenScorMetric::where('dimension', 'PLAN')->sum('final_score'),
            'SOURCE' => GreenScorMetric::where('dimension', 'SOURCE')->sum('final_score'),
            'MAKE' => GreenScorMetric::where('dimension', 'MAKE')->sum('final_score'),
            'DELIVER' => GreenScorMetric::where('dimension', 'DELIVER')->sum('final_score'),
            'RETURN' => GreenScorMetric::where('dimension', 'RETURN')->sum('final_score'),
        ];

        // Recent Products
        $recentProducts = Product::latest()->take(5)->get();
        $recentMaterials = RawMaterial::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalSales',
            'totalPurchases',
            'totalProducts',
            'totalProductStock',
            'lowStockProducts',
            'totalRawMaterials',
            'totalMaterialStock',
            'lowStockMaterials',
            'activeProductions',
            'completedProductions',
            'totalSuppliers',
            'ecoSuppliers',
            'totalCustomers',
            'latestGscorResult',
            'gscorMetrics',
            'dimensionScores',
            'recentProducts',
            'recentMaterials'
        ));
    }
}
