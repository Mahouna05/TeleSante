<?php

namespace App\Http\Controllers;

use App\Models\RendezVous;
use App\Models\Medecin;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RendezVousController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        $rendezVousAVenir = RendezVous::where('patientId', $patient->id)
            ->where('date_heure', '>', Carbon::now())
            ->orderBy('date_heure', 'asc')
            ->get();
            
        $rendezVousPasses = RendezVous::where('patientId', $patient->id)
            ->where('date_heure', '<', Carbon::now())
            ->orderBy('date_heure', 'desc')
            ->get();
            
        return view('rendez-vous.index', compact('rendezVousAVenir', 'rendezVousPasses'));
    }
    
    public function create()
    {
        $medecins = Medecin::with('user')->get();
        return view('rendez-vous.create', compact('medecins'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date' => 'required|date|after:today',
            'heure' => 'required',
            'type' => 'required|in:video,audio,chat',
            'motif' => 'required|string|max:255',
        ]);
        
        $dateHeure = Carbon::parse($validated['date'] . ' ' . $validated['heure']);
        
        $rendezVous = new RendezVous();
        $rendezVous->patient_id = auth()->user()->patient->id;
        $rendezVous->medecin_id = $validated['medecin_id'];
        $rendezVous->date_heure = $dateHeure;
        $rendezVous->type = $validated['type'];
        $rendezVous->motif = $validated['motif'];
        $rendezVous->statut = 'en attente';
        $rendezVous->save();
        
        // Créer une notification pour le médecin
        $notification = new Notification();
        $notification->utilisateur_id = Medecin::find($validated['medecin_id'])->user->id;
        $notification->type = 'info';
        $notification->message = 'Nouvelle demande de rendez-vous de ' . auth()->user()->prenom . ' ' . auth()->user()->nom;
        $notification->lu = false;
        $notification->save();
        
        return redirect()->route('rendez-vous.index')->with('success', 'Votre demande de rendez-vous a été envoyée avec succès');
    }
    
    public function edit(RendezVous $rendezVous)
    {
        $this->authorize('update', $rendezVous);
        
        $medecins = Medecin::with('user')->get();
        return view('rendez-vous.edit', compact('rendezVous', 'medecins'));
    }
    
    public function update(Request $request, RendezVous $rendezVous)
    {
        $this->authorize('update', $rendezVous);
        
        $validated = $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date' => 'required|date|after:today',
            'heure' => 'required',
            'type' => 'required|in:video,audio,chat',
            'motif' => 'required|string|max:255',
        ]);
        
        $dateHeure = Carbon::parse($validated['date'] . ' ' . $validated['heure']);
        
        $rendezVous->medecin_id = $validated['medecin_id'];
        $rendezVous->date_heure = $dateHeure;
        $rendezVous->type = $validated['type'];
        $rendezVous->motif = $validated['motif'];
        $rendezVous->statut = 'en attente'; // Remis en attente pour reconfirmation
        $rendezVous->save();
        
        // Créer une notification pour le médecin
        $notification = new Notification();
        $notification->utilisateur_id = Medecin::find($validated['medecin_id'])->user->id;
        $notification->type = 'info';
        $notification->message = 'Modification de rendez-vous par ' . auth()->user()->prenom . ' ' . auth()->user()->nom;
        $notification->lu = false;
        $notification->save();
        
        return redirect()->route('rendez-vous.index')->with('success', 'Votre rendez-vous a été modifié avec succès');
    }
    
    public function destroy(RendezVous $rendezVous)
    {
        $this->authorize('delete', $rendezVous);
        
        // Créer une notification pour le médecin
        $notification = new Notification();
        $notification->utilisateur_id = Medecin::find($rendezVous->medecin_id)->user->id;
        $notification->type = 'info';
        $notification->message = 'Annulation de rendez-vous par ' . auth()->user()->prenom . ' ' . auth()->user()->nom;
        $notification->lu = false;
        $notification->save();
        
        $rendezVous->delete();
        
        return redirect()->route('rendez-vous.index')->with('success', 'Votre rendez-vous a été annulé avec succès');
    }
}