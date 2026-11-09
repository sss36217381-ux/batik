<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\RawMaterial;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(): View
    {
        $purchases = Purchase::with(['supplier', 'user', 'details.rawMaterial'])->latest()->paginate(10);
        $suppliers = Supplier::all();
        $rawMaterials = RawMaterial::all();

        return view('modules.purchases.index', compact('purchases', 'suppliers', 'rawMaterials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'raw_material_id' => ['required', 'exists:raw_materials,id'],
            'purchase_date' => ['required', 'date'],
            'quantity' => ['required', 'numeric', 'min:0.1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $subtotal = $validated['quantity'] * $validated['unit_price'];
        $rawMat = RawMaterial::find($validated['raw_material_id']);

        $purchase = Purchase::create([
            'purchase_number' => 'PO-'.date('Ymd').'-'.strtoupper(bin2hex(random_bytes(2))),
            'supplier_id' => $validated['supplier_id'],
            'user_id' => auth()->id(),
            'purchase_date' => $validated['purchase_date'],
            'total_amount' => $subtotal,
            'payment_status' => 'paid',
            'status' => 'received',
            'notes' => $validated['notes'] ?? null,
        ]);

        $purchase->details()->create([
            'raw_material_id' => $rawMat->id,
            'quantity' => $validated['quantity'],
            'unit_price' => $validated['unit_price'],
            'subtotal' => $subtotal,
            'eco_friendly_verified' => $rawMat->is_eco_friendly,
        ]);

        // Update inventory stock
        $rawMat->increment('stock', $validated['quantity']);

        return redirect()->route('purchases.index')->with('success', 'Transaksi pembelian berhasil disimpan dan stok telah bertambah.');
    }
}
