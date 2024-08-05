<?php

namespace App\Http\Controllers;

use App\Models\FitnessCenter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('fitnessCenter')->get();
        $roles = ['receptionist', 'controller', 'manager', 'admin', 'superadmin'];
        $centers = FitnessCenter::all();
        // Compter le nombre d'utilisateurs excepté les superadmins
        $userCount = User::where('role', '!=', 'superadmin')->count();

        return view('users.index', compact('users', 'roles', 'centers', 'userCount'));
    }

    // Enregistrer ou mettre à jour un utilisateur

    public function store(Request $request)
    {
        
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:receptionist,controller,manager,admin,superadmin',
            'fitness_center_id' => 'nullable|exists:fitness_centers,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (in_array($request->role, ['manager', 'admin', 'superadmin'])) {
            $existingUser = User::where('fitness_center_id', $request->fitness_center_id)
                ->where('role', $request->role)
                ->first();

            if ($existingUser) {
                return redirect()->back()->withErrors(['fitness_center_id' => 'Impossible d\'affecter deux managers ou admins à un centre.']);
            }
        }

        User::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'role' => $request->role,
            'fitness_center_id' => $request->fitness_center_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('message', 'Utilisateur créé avec succès !');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:receptionist,controller,manager,admin,superadmin',
            'fitness_center_id' => 'nullable|exists:fitness_centers,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if($user->role !== $request->role){
            if (in_array($request->role, ['manager', 'admin', 'superadmin'])) {
                $existingUser = User::where('fitness_center_id', $request->fitness_center_id)
                    ->where('role', $request->role)
                    ->where('id', '!=', $user->id)
                    ->first();

                if ($existingUser) {
                    return redirect()->back()->withErrors(['fitness_center_id' => 'Impossible d\'affecter deux managers ou admins à un centre.']);
                }
            }
        }

        if($user->role == $request->role){
            $data = $request->only('fullname', 'email', 'role', 'fitness_center_id');
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('message', 'Utilisateur ajouté avec succès !');
    }

    // Supprimer un utilisateur

    public function destroy(User $user)
    {
        // Vérifier si l'utilisateur à supprimer est un admin
        if ($user->role === 'admin') {
            // Vérifier si l'utilisateur authentifié est un superadmin
            if (Auth::user()->role !== 'superadmin') {
                return redirect()->route('users.index')->withErrors(['error' => 'Impossible de supprimer l\'administrateur principal.']);
            }
        }

        if ($user->role === Auth::user()->role) {
            return redirect()->route('users.index')->withErrors(['error' => 'Vous n\'avez pas les droits pour supprimer votre compte.']);
        }

        if (Auth::user()->role !== 'superadmin' AND Auth::user()->role !== 'admin' AND Auth::user()->role !== 'manager') {
            return redirect()->route('users.index')->withErrors(['error' => 'Vous n\'avez pas les droits pour supprimer un compte.']);
        }

        $user->delete();
        return redirect()->route('users.index')->with('message', 'Utilisateur supprimé avec succès !');
    }
}
