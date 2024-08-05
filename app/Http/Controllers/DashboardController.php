<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\ContractSale;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductSale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Afficher la liste des centres de fitness
    public function index(Request $request)
    {
        $phone_input_exists = true;
        $user = Auth::user();
        
        // Get today's date
        $today = Carbon::today();

        // Base query for fetching sales
        $salesQuery = ProductSale::with('product', 'customer', 'user', 'productFitnessCenter', 'userFitnessCenter')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc');

        // Apply search filter if provided
        $search = $request->input('shop_sales_serach');
        if ($search) {
            $salesQuery->where(function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    $query->where('product_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('fullname', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('fullname', 'like', '%' . $search . '%');
                });
            });
        }

        // Fetch today's sales with related data and pagination
        $sales = $salesQuery->paginate(15);

        // Fetch products based on user role
        $productsQuery = Product::with('category', 'creator', 'fitnessCenter');
        if ($user->role !== 'admin' && $user->role !== 'superadmin') {
            $productsQuery->where('fitness_center_id', $user->fitness_center_id);
        }
        $products = $productsQuery->get();
        

        // Base query for fetching contract sales
        $contractSalesQuery = ContractSale::with('contract', 'customer', 'user', 'contractFitnessCenter', 'userFitnessCenter')
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc');

        // Apply search filter if provided
        $search = $request->input('shop_contracts_sales_serach');
        if ($search) {
            $contractSalesQuery->where(function ($query) use ($search) {
                $query->whereHas('contract', function ($query) use ($search) {
                    $query->where('contract_name', 'like', '%' . $search . '%');
                })
                ->orWhereHas('customer', function ($query) use ($search) {
                    $query->where('fullname', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('fullname', 'like', '%' . $search . '%');
                });
            });
        }

        // Fetch today's contract sales with related data and pagination
        $contractSales = $contractSalesQuery->paginate(15);

        // Fetch customers ordered by creation date
        $customers = Customer::orderBy('created_at', 'desc')->get();

        // Fetch contracts based on user role
        $contractsQuery = Contract::with('creator', 'fitnessCenter');
        if ($user->role !== 'admin' && $user->role !== 'superadmin') {
            $contractsQuery->where('fitness_center_id', $user->fitness_center_id);
        }
        $contracts = $contractsQuery->get();

        // Calculate total sales for today
        $totalSalesToday = ProductSale::whereDate('created_at', $today)->sum('total_amount');
        $totalContractSalesToday = ContractSale::whereDate('created_at', $today)->sum('total_amount');

        return view('dashboard.index', compact('contractSales', 'sales', 'contracts', 'customers', 'products', 'totalSalesToday','totalContractSalesToday', 'search','phone_input_exists'));
    }
}
