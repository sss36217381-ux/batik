<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FinanceController extends Controller
{
    public function index(): View
    {
        $salesRevenue = Sale::where('status', 'completed')->sum('grand_total');
        $purchaseCost = Purchase::where('status', 'received')->sum('total_amount');
        $expenses = Expense::with('user')->latest()->take(20)->get();
        $totalExpenses = Expense::sum('amount');

        $grossProfit = $salesRevenue - $purchaseCost;
        $netProfit = $grossProfit - $totalExpenses;

        return view('modules.finance.index', compact(
            'salesRevenue',
            'purchaseCost',
            'expenses',
            'totalExpenses',
            'grossProfit',
            'netProfit'
        ));
    }

    public function storeExpense(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string'],
            'amount' => ['required', 'numeric', 'min:1'],
            'expense_date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        Expense::create([
            'expense_number' => 'EXP-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(2))),
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'expense_date' => $validated['expense_date'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('finance.index')->with('success', 'Biaya pengeluaran berhasil dicatat.');
    }
}
