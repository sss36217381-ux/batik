<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Expense;
use App\Models\Product;
use App\Models\ProductionOrder;
use App\Models\Purchase;
use App\Models\RawMaterial;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        $salesCount = Sale::count();
        $salesTotal = Sale::sum('grand_total');
        $purchaseCount = Purchase::count();
        $purchaseTotal = Purchase::sum('total_amount');
        $productionCount = ProductionOrder::count();
        $expenseTotal = Expense::sum('amount');
        $supplierCount = Supplier::count();
        $customerCount = Customer::count();
        $products = Product::all();
        $materials = RawMaterial::all();

        return view('modules.reports.index', compact(
            'salesCount',
            'salesTotal',
            'purchaseCount',
            'purchaseTotal',
            'productionCount',
            'expenseTotal',
            'supplierCount',
            'customerCount',
            'products',
            'materials'
        ));
    }
}
