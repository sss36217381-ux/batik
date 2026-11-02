<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RawMaterialController extends Controller
{
    public function index(): View
    {
        $rawMaterials = RawMaterial::latest()->paginate(10);
        return view('modules.raw_materials.index', compact('rawMaterials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'unique:raw_materials,code'],
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:kain,malam,pewarna_alami,pewarna_sintetis,bahan_pendukung'],
            'unit' => ['required', 'string', 'max:30'],
            'stock' => ['required', 'numeric', 'min:0'],
            'min_stock' => ['required', 'numeric', 'min:0'],
            'unit_price' => ['required', 'numeric', 'min:0'],
            'is_eco_friendly' => ['boolean'],
            'description' => ['nullable', 'string'],
        ]);

        $validated['is_eco_friendly'] = $request->boolean('is_eco_friendly');

        RawMaterial::create($validated);

        return redirect()->route('raw-materials.index')->with('success', 'Bahan baku berhasil ditambahkan.');
    }

    public function destroy(RawMaterial $rawMaterial): RedirectResponse
    {
        $rawMaterial->delete();
        return redirect()->route('raw-materials.index')->with('success', 'Bahan baku berhasil dihapus.');
    }
}
