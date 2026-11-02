<?php

namespace App\Http\Controllers;

use App\Models\ReturnOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnController extends Controller
{
    public function index(): View
    {
        $returns = ReturnOrder::with('user')->latest()->paginate(10);
        return view('modules.returns.index', compact('returns'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'return_type' => ['required', 'in:purchase_return,sale_return'],
            'party_name' => ['required', 'string', 'max:255'],
            'return_date' => ['required', 'date'],
            'reason' => ['required', 'string'],
            'handling_action' => ['required', 'in:replace,repair,refund,dispose'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ]);

        ReturnOrder::create([
            'return_number' => 'RET-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2))),
            'return_type' => $validated['return_type'],
            'reference_id' => 1,
            'party_name' => $validated['party_name'],
            'return_date' => $validated['return_date'],
            'total_amount' => $validated['total_amount'],
            'reason' => $validated['reason'],
            'handling_action' => $validated['handling_action'],
            'status' => 'requested',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('returns.index')->with('success', 'Klaim retur berhasil dicatat.');
    }
}
