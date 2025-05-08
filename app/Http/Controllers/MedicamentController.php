<?php

namespace App\Http\Controllers;

use App\Models\Ordonnance;
use App\Models\Medicament;
use App\Models\Commande;
use Illuminate\Http\Request;
use PDF;

class MedicamentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        $ordonnancesActives = Ordonnance::whereHas('consultation', function($query) use ($patient) {
            $query->where('patientId', $patient->id);
        })
        ->where('date_expiration', '>', now())
        ->orderBy('date_creation', 'desc')
        ->get();
        
        $ordonnancesExpirees = Ordonnance::whereHas('consultation', function($query) use ($patient) {
            $query->where('patientId', $patient->id);
        })
        ->where('date_expiration', '<', now())
        ->orderBy('date_creation', 'desc')
        ->take(5)
        ->get();
        
        $commandes = Commande::where('patientId', $patient->id)
            ->orderBy('date_commande', 'desc')
            ->get();
        
        return view('patient.medicaments.index', compact('ordonnancesActives', 'ordonnancesExpirees', 'commandes'));
    }
    
    public function showOrdonnance(Ordonnance $ordonnance)
    {
        $this->authorize('view', $ordonnance);
        
        return view('patient.medicaments.ordonnance', compact('ordonnance'));
    }
    
    public function commander(Request $request)
    {
        $request->validate([
            'ordonnance_id' => 'required|exists:ordonnances,id',
            'medicaments' => 'required|array',
            'medicaments.*' => 'exists:medicaments,id',
            'adresse_livraison' => 'required|string|max:255',
        ]);
        
        $commande = new Commande();
        $commande->patient_id = auth()->user()->patient->id;
        $commande->ordonnance_id = $request->ordonnance_id;
        $commande->adresse_livraison = $request->adresse_livraison;
        $commande->statut = 'en attente';
        $commande->date_commande = now();
        $commande->save();
        
        $montantTotal = 0;
        foreach ($request->medicaments as $medicamentId) {
            $medicament = Medicament::find($medicamentId);
            $commande->medicaments()->attach($medicamentId, [
                'quantite' => 1, // Par défaut, à ajuster selon vos besoins
                'prix_unitaire' => $medicament->prix,
            ]);
            $montantTotal += $medicament->prix;
        }
        
        $commande->montant_total = $montantTotal;
        $commande->save();
        
        return redirect()->route('medicaments.index')
            ->with('success', 'Votre commande a été enregistrée avec succès. Un pharmacien vous contactera prochainement.');
    }
    
    public function imprimerOrdonnance(Ordonnance $ordonnance)
    {
        $this->authorize('view', $ordonnance);
        
        $pdf = PDF::loadView('patient.medicaments.pdf.ordonnance', compact('ordonnance'));
        
        return $pdf->download('ordonnance_' . $ordonnance->id . '.pdf');
    }
}