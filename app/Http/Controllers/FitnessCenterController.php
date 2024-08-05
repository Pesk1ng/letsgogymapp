<?php

namespace App\Http\Controllers;

use App\Models\FitnessCenter;
use App\Models\User;
use Illuminate\Http\Request;

class FitnessCenterController extends Controller
{
    // Afficher la liste des centres de fitness
    public function index()
    {
        // Récupérer tous les centres de fitness
        $centers = FitnessCenter::all();
        // Vérifier s'il existe un utilisateur avec le rôle 'admin'
        $admin = User::where('role', 'admin')->first();
        // Vérifier s'il existe un utilisateur avec le rôle 'manager'
        $manager = User::where('role', 'manager')->first();
        return view('centers.index', compact('centers', 'admin', 'manager'));
    }

    // Afficher le formulaire de création d'un nouveau centre
    public function create()
    {
        $users = User::where('role', 'manager')->get();
        return view('centers.create', compact('users'));
    }

    // Enregistrer un nouveau centre de fitness
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'email_address' => 'nullable|email|max:255',
        ]);

        FitnessCenter::create($request->all());

        return redirect()->route('centers.index')->with('success', 'Fitness center created successfully.');
    }

    // Afficher les détails d'un centre de fitness
    public function show(FitnessCenter $center)
    {
        return view('centers.show', compact('center'));
    }

    // Afficher le formulaire d'édition d'un centre de fitness
    public function edit(FitnessCenter $center)
    {
        $users = User::where('role', 'manager')->get();
        return view('centers.edit', compact('center', 'users'));
    }

    // Mettre à jour les informations d'un centre de fitness
    public function update(Request $request, FitnessCenter $center)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'email_address' => 'nullable|email|max:255',
        ]);

        $center->update($request->all());

        return redirect()->route('centers.index')->with('success', 'Fitness center updated successfully.');
    }

    // Supprimer un centre de fitness
    public function destroy(FitnessCenter $center)
    {
        $center->delete();

        return redirect()->route('centers.index')->with('success', 'Fitness center deleted successfully.');
    }

    // Assigner un manager à un centre de fitness
    public function assignManager(Request $request, FitnessCenter $center)
    {
        $request->validate([
            'manager_id' => 'required|exists:users,id',
        ]);

        $center->manager_id = $request->manager_id;
        $center->save();

        return redirect()->route('centers.show', $center)->with('success', 'Manager assigned successfully.');
    }

    // Retirer le manager d'un centre de fitness
    public function removeManager(FitnessCenter $center)
    {
        $center->manager_id = null;
        $center->save();

        return redirect()->route('centers.show', $center)->with('success', 'Manager removed successfully.');
    }
}
