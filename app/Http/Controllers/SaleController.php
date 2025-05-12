<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Services\PriceCalculator;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function __construct(
        protected PriceCalculator $calculator
    ) {
        $this->middleware('auth');
    }

    /**
     * Show all sales for the authenticated user.
     */
    public function index(): View
    {
        // You could paginate here if you expect many records
        $sales = auth()->user()->sales()->latest()->get(['quantity', 'unit_cost', 'cost', 'selling_price', 'created_at']);

        return view('coffee_sales', compact('sales'));
    }

    /**
     * Show the form to create a new sale.
     */
    public function create(): View
    {
        return view('coffee_sales');
    }

    /**
     * Validate, calculate, persist, then redirect with flash.
     */
    public function store(StoreSaleRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        $results = $this->calculator->calculate(
            $data['quantity'],
            $data['unit_cost']
        );

        // Use the relationship to auto-assign user_id
        $user->sales()->create([
            'quantity' => $data['quantity'],
            'unit_cost' => $data['unit_cost'],
            'cost' => $results['cost'],
            'selling_price' => $results['selling_price'],
        ]);

        return redirect()->route('sales.index')
            ->with('calculatedPrice', $results['selling_price']);
    }
}
