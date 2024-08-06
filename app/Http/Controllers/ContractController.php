<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\FitnessCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'superadmin'])) {
            // Récupérer tous les contrats pour les admins et superadmins
            $contracts = Contract::with('creator', 'fitnessCenter')->get();
        } else {
            // Récupérer uniquement les contrats du centre de l'utilisateur
            $contracts = Contract::with('creator', 'fitnessCenter')
                ->where('fitness_center_id', $user->fitness_center_id)
                ->get();
        }

        $centers = FitnessCenter::all();
        $datatable_exist = true;
        return view('contracts.index', compact('contracts', 'centers', 'datatable_exist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
        
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contract_name' => 'required|string|max:100',
            'contract_code' => 'nullable|string|max:255|unique:contracts',
            'contract_duration' => 'required|integer|min:1',
            'fitness_center_id' => 'exists:fitness_centers,id',
            'contract_amount' => 'required|integer|min:0',
        ]);

        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Déterminer le fitness_center_id en fonction du rôle de l'utilisateur
        $fitnessCenterId = $user->role === 'admin' || $user->role === 'superadmin' 
            ? $request->fitness_center_id 
            : $user->fitness_center_id;

        // Vérifier que ce centre n'a pas déjà un contrat du même nom
        $existingContract = Contract::where('contract_name', $request->contract_name)
            ->where('fitness_center_id', $fitnessCenterId)
            ->first();

        if ($existingContract) {
            return redirect()->back()->withErrors(['contract_name' => 'Un contrat du même type existe déjà.']);
        }

        // Génération d'un code unique
        $contractCode = 'CNT-' . strtoupper(uniqid());

        // Création du contrat avec le créateur spécifié
        Contract::create([
            'contract_name' => $request->contract_name,
            'contract_code' => $contractCode,
            'contract_duration' => $request->contract_duration,
            'fitness_center_id' => $fitnessCenterId,
            'contract_create_by' => $user->id, // Attribuer l'utilisateur authentifié comme créateur
            'contract_creator_name' => $user->fullname, // Stockez le nom de l'utilisateur
            'contract_amount' => $request->contract_amount,
        ]);

        return redirect()->route('contracts.index')->with('message', 'Contrat créé avec succès !');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'contract_name' => 'required|string|max:100',
            'contract_duration' => 'required|integer|min:1',
            'contract_amount' => 'required|integer|min:0',
        ]);

         // Récupérer l'utilisateur actuellement authentifié
         $user = Auth::user();

        // Déterminer le fitness_center_id du contrat à modifier
        $fitnessCenterId = $contract->fitness_center_id;
        $contractUniqueCode = $contract->contract_code;

        // Vérifier que ce centre n'a pas déjà un contrat du même nom
        $existingContract = Contract::where('contract_name', $request->contract_name)
            ->where('fitness_center_id', $fitnessCenterId)
            ->first();

        if ($existingContract && $contract->contract_name !== $request->contract_name) {
            return redirect()->back()->withErrors(['contract_name' => 'Un contrat du même type existe déjà.']);
        }

        $contract->update([
            'contract_name' => $request->contract_name,
            'contract_duration' => $request->contract_duration,
            'contract_amount' => $request->contract_amount,
        ]);

        return redirect()->route('contracts.index', $contract)->with('message', 'Contrat mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est un admin ou un superadmin
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('customers.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à supprimer des contrats.');
        }

        // Supprimer le contrat
        $contract->delete();

        // Rediriger avec un message de succès
        return redirect()->route('contracts.index')->with('message', 'Contrat supprimé avec succès !');
    }
}
