<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function index(): View
    {
        $products = Product::all();
        $rawMaterials = RawMaterial::all();
        $movements = InventoryMovement::with('user')->latest()->take(20)->get();

        return view('modules.inventory.index', compact('products', 'rawMaterials', 'movements'));
    }

    public function adjust(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_type' => ['required', 'in:product,raw_material'],
            'item_id' => ['required', 'integer'],
            'movement_type' => ['required', 'in:in,out,adjustment,waste'],
            'quantity' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['required', 'string', 'max:255'],
        ]);

        if ($validated['item_type'] === 'product') {
            $item = Product::findOrFail($validated['item_id']);
            if (in_array($validated['movement_type'], ['out', 'waste'])) {
                $item->decrement('stock', (int) $validated['quantity']);
            } else {
                $item->increment('stock', (int) $validated['quantity']);
            }
        } else {
            $item = RawMaterial::findOrFail($validated['item_id']);
            if (in_array($validated['movement_type'], ['out', 'waste'])) {
                $item->decrement('stock', $validated['quantity']);
            } else {
                $item->increment('stock', $validated['quantity']);
            }
        }

        InventoryMovement::create([
            'item_type' => $validated['item_type'],
            'item_id' => $validated['item_id'],
            'movement_type' => $validated['movement_type'],
            'quantity' => $validated['quantity'],
            'reference_type' => 'Manual Adjustment',
            'notes' => $validated['notes'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('inventory.index')->with('success', 'Penyesuaian stok berhasil dicatat ke kartu stok.');
    }
}
