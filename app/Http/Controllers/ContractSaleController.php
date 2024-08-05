<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractSale;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractSaleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity_sold' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $contract = Contract::findOrFail($request->contract_id);
        $customer = Customer::findOrFail($request->customer_id);

        // Calculate the total amount
        $totalAmount = $request->quantity_sold * $contract->contract_amount;

        // Create the contract sale entry
        ContractSale::create([
            'contract_id' => $request->contract_id,
            'customer_id' => $request->customer_id,
            'customer_name' => $customer->fullname,
            'user_id' => $user->id,
            'user_name' => $user->fullname,
            'contract_fitness_center_id' => $contract->fitness_center_id,
            'user_fitness_center_id' => $user->fitness_center_id,
            'quantity_sold' => $request->quantity_sold,
            'total_amount' => $totalAmount,
        ]);

        return redirect()->route('dashboard.index')->with('success', 'Contract sold successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContractSale $contractSale)
    {
        //
    }
}
