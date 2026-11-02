<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(): View
    {
        $suppliers = Supplier::withCount('purchases')->latest()->paginate(10);
        return view('modules.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'unique:suppliers,code'],
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'is_eco_certified' => ['boolean'],
            'eco_rating' => ['nullable', 'numeric', 'between:1,5'],
        ]);

        $validated['is_eco_certified'] = $request->boolean('is_eco_certified');
        $validated['eco_rating'] = $validated['eco_rating'] ?? 3.00;

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Data pemasok berhasil disimpan.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Pemasok berhasil dihapus.');
    }
}
