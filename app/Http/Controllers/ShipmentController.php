<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Shipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShipmentController extends Controller
{
    public function index(): View
    {
        $shipments = Shipment::with('sale.customer')->latest()->paginate(10);
        $pendingSales = Sale::doesntHave('shipment')->where('status', 'completed')->get();

        return view('modules.shipments.index', compact('shipments', 'pendingSales'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sale_id' => ['required', 'exists:sales,id'],
            'courier_name' => ['required', 'string', 'max:255'],
            'shipping_address' => ['required', 'string'],
            'shipping_date' => ['required', 'date'],
            'tracking_number' => ['nullable', 'string', 'max:100'],
        ]);

        $validated['status'] = 'shipped';
        $validated['is_on_time'] = true;

        Shipment::create($validated);

        return redirect()->route('shipments.index')->with('success', 'Data pengiriman pesanan berhasil dibuat.');
    }
}

