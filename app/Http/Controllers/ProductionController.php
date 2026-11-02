<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductionOrder;
use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductionController extends Controller
{
    public function index(): View
    {
        $orders = ProductionOrder::with(['product', 'user', 'details.rawMaterial'])->latest()->paginate(10);
        $products = Product::all();
        $rawMaterials = RawMaterial::all();

        return view('modules.production.index', compact('orders', 'products', 'rawMaterials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'target_product_id' => ['required', 'exists:products,id'],
            'planned_quantity' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date'],
            'stage' => ['required', 'string'],
            'water_usage_liters' => ['nullable', 'numeric', 'min:0'],
            'waste_generated_kg' => ['nullable', 'numeric', 'min:0'],
            'recycled_wax_kg' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $order = ProductionOrder::create([
            'order_number' => 'PRD-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2))),
            'target_product_id' => $validated['target_product_id'],
            'planned_quantity' => $validated['planned_quantity'],
            'actual_quantity' => 0,
            'start_date' => $validated['start_date'],
            'stage' => $validated['stage'],
            'status' => 'in_progress',
            'water_usage_liters' => $validated['water_usage_liters'] ?? 0,
            'waste_generated_kg' => $validated['waste_generated_kg'] ?? 0,
            'recycled_wax_kg' => $validated['recycled_wax_kg'] ?? 0,
            'notes' => $validated['notes'] ?? null,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('production.index')->with('success', "Order produksi {$order->order_number} berhasil dimulai.");
    }
}
