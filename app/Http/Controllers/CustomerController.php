<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\FitnessCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $customers = Customer::query()
        ->when($search, function($query, $search) {
            return $query->where('fullname', 'LIKE', "%{$search}%")
                         ->orWhere('phoneNumber', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
        }, function($query) {
            return $query->orderBy('created_at', 'desc');
        })
        ->paginate(15);

        // $customers = Customer::orderBy('created_at', 'desc')->paginate(15);
        $centers = FitnessCenter::all();
        $phone_input_exists = true;
        return view('customers.index', compact('customers', 'centers', 'phone_input_exists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phoneNumber' => 'required|string|unique:customers,phoneNumber',
        ]);

        // Obtenir l'utilisateur connecté
        $user = Auth::user();

        // Créer un identifiant unique
        $uniqueId = 'lgg' . strtoupper(uniqid());

        // Gérer le fichier avatar
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarPath = $avatar->store('media/avatars', 'public'); // Stocke le fichier dans le répertoire 'public/avatars'
        }

        // Créer un nouvel enregistrement dans la table customers
        $customer = Customer::create([
            'unique_id' => $uniqueId,
            'fullname' => $validatedData['fullname'],
            'email' => $validatedData['email'],
            'avatar' => $avatarPath,
            'phoneNumber' => $validatedData['phoneNumber'],
            'customer_create_by' => $user->id,
            'customer_creator_name' => $user->fullname, // Nom de l'utilisateur connecté
            'fitness_center_id' => $user->fitness_center_id,
        ]);

        // Rediriger avec un message de succès
        return redirect()->route('customers.index', $customer->id)->with('message', 'Client ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    // public function show(Customer $customer)
    // {
    //     $customer = Customer::findOrFail($customer);
    //     return view('customer.show', compact('customer'));
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(Customer $customer)
    // {
        
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'phoneNumber' => 'required|string|unique:customers,phoneNumber,' . $customer->id,
        ]);

        // Obtenir l'utilisateur connecté
        $user = Auth::user();

        // Mettre à jour les informations du client
        $customer->update([
            'fullname' => $validatedData['fullname'],
            'email' => $validatedData['email'],
            'phoneNumber' => $validatedData['phoneNumber'],
        ]);

        // Rediriger vers la page de détails du client avec un message de succès
        return redirect()->route('customers.index', $customer->id)
                         ->with('message', 'Profil du client mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur est un admin ou un superadmin
        if (!in_array($user->role, ['admin', 'superadmin', 'manager'])) {
            return redirect()->route('customers.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à supprimer des clients.');
        }
        
        $customer->delete();

        return redirect()->route('customers.index')
                         ->with('message', 'Profil du client supprimé avec succès !');
    }
}
