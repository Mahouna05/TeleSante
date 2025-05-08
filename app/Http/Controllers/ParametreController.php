<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class ParametresController extends Controller
{
    /**
     * Afficher la page des paramètres
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('patient.parametres.index', compact('user'));
    }
    
    /**
     * Mettre à jour les informations du profil
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'telephone' => ['required', 'string', 'max:20'],
            'photo_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);
        
        // Mise à jour des informations de base
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->telephone = $request->telephone;
        
        // Traitement de la photo de profil
        if ($request->hasFile('photo_profil')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo_profil && Storage::exists('public/profils/' . $user->photo_profil)) {
                Storage::delete('public/profils/' . $user->photo_profil);
            }
            
            // Enregistrer la nouvelle photo
            $filename = time() . '.' . $request->photo_profil->extension();
            $request->photo_profil->storeAs('public/profils', $filename);
            $user->photo_profil = $filename;
        }
        
        $user->save();
        
        return redirect()->route('patient.parametres.index')->with('success', 'Profil mis à jour avec succès');
    }
    
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        $user = Auth::user();
        
        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.'])->withInput();
        }
        
        // Mettre à jour le mot de passe
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('patient.parametres.index')->with('success', 'Mot de passe mis à jour avec succès');
    }
    
    /**
     * Mettre à jour les préférences de l'utilisateur
     */
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'langue' => ['required', 'string', 'in:fr,en'],
            'format_date' => ['required', 'string', 'in:d/m/Y,m/d/Y,Y-m-d'],
            'format_heure' => ['required', 'string', 'in:H:i,h:i A'],
            'theme' => ['required', 'string', 'in:clair,sombre,auto'],
        ]);
        
        $user = Auth::user();
        
        // Stocker les préférences dans la base de données
        // Option 1: Si vous avez une table dédiée aux préférences
        $user->preference()->updateOrCreate(
            ['utilisateur_id' => $user->id],
            [
                'langue' => $request->langue,
                'format_date' => $request->format_date,
                'format_heure' => $request->format_heure,
                'theme' => $request->theme,
            ]
        );
        
        // Option 2: Si vous utilisez un champ JSON dans la table utilisateurs
        $preferences = [
            'langue' => $request->langue,
            'format_date' => $request->format_date,
            'format_heure' => $request->format_heure,
            'theme' => $request->theme,
        ];
        
        $user->preferences = json_encode($preferences);
        $user->save();
        
        // Mettre à jour la session pour le thème et la langue
        Session::put('theme', $request->theme);
        Session::put('locale', $request->langue);
        app()->setLocale($request->langue);
        
        return redirect()->route('patient.parametres.index')->with('success', 'Préférences mises à jour avec succès');
    }
    
    /**
     * Préparer la suppression du compte (confirmation)
     */
    public function confirmDeleteAccount()
    {
        return view('patient.parametres.delete-account');
    }
    
    /**
     * Supprimer définitivement le compte
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);
        
        $user = Auth::user();
        
        // Vérifier que le mot de passe est correct
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Le mot de passe est incorrect.'])->withInput();
        }
        
        // Archiver ou supprimer les données associées
        // Cela dépendra de votre politique de confidentialité et de vos besoins
        
        // Désactiver le compte plutôt que le supprimer complètement
        $user->statut = 'inactif';
        $user->email = $user->email . '.deleted.' . time();
        $user->save();
        
        // Ou supprimer complètement le compte
        // $user->delete();
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Votre compte a été supprimé avec succès');
    }
}