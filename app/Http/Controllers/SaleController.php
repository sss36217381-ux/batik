<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(): View
    {
        $sales = Sale::with(['customer', 'user', 'details.product'])->latest()->paginate(10);
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();

        return view('modules.sales.index', compact('sales', 'customers', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:cash,transfer_bank,qris'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if ($product->stock < $validated['quantity']) {
            return back()->with('error', "Stok kain {$product->name} tidak mencukupi (Tersisa: {$product->stock}).");
        }

        $subtotal = $validated['quantity'] * $product->selling_price;
        $discount = $validated['discount_amount'] ?? 0;
        $grandTotal = max(0, $subtotal - $discount);

        $sale = Sale::create([
            'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2))),
            'customer_id' => $validated['customer_id'],
            'user_id' => auth()->id(),
            'sale_date' => now()->toDateString(),
            'total_amount' => $subtotal,
            'discount_amount' => $discount,
            'grand_total' => $grandTotal,
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
            'status' => 'completed',
            'notes' => $validated['notes'] ?? null,
        ]);

        $sale->details()->create([
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'unit_price' => $product->selling_price,
            'subtotal' => $subtotal,
        ]);

        $product->decrement('stock', $validated['quantity']);

        return redirect()->route('sales.index')->with('success', "Transaksi penjualan {$sale->invoice_number} berhasil diproses.");
    }
}

