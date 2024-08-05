<?php

namespace App\Http\Controllers;

use App\Models\Cashbox;
use App\Models\ContractSale;
use App\Models\ProductSale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashboxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $fitnessCenter = $user->fitnessCenter;
        $fitnessCenterId = $fitnessCenter->id;
        $fitnessCenterName = $fitnessCenter->name;

        // Get today's date
        $today = Carbon::today();

        // Calculate today's total sales for products
        $totalProductSalesToday = ProductSale::where('user_fitness_center_id', $fitnessCenterId)
                            ->whereDate('created_at', $today)
                            ->sum('total_amount');

        // Calculate today's total sales for contracts
        $totalContractSalesToday = ContractSale::where('user_fitness_center_id', $fitnessCenterId)
                            ->whereDate('created_at', $today)
                            ->sum('total_amount');

        // Total sales for today
        $totalSalesToday = $totalProductSalesToday + $totalContractSalesToday;

        // Fetch or create cashbox record for today
        // $cashbox = Cashbox::firstOrCreate(
        //     ['fitness_center_id' => $fitnessCenterId],
        //     [
        //         'user_id' => $user->id,
        //         'user_name' => $user->name,
        //         'total_sales_today' => $totalSalesToday,
        //         'description' => null,
        //     ]
        // );

        // Update the cashbox total_sales_today
        // $cashbox->update(['total_sales_today' => $totalSalesToday]);

        return view('accounting.cashbox.index', compact('today', 'fitnessCenterName', 'totalProductSalesToday', 'totalContractSalesToday'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashbox $cashbox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cashbox $cashbox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cashbox $cashbox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cashbox $cashbox)
    {
        //
    }
}
