<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;
use PDF;

class PaiementController extends Controller
{
    /**
     * Affiche la liste des paiements du patient.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $patient = Auth::user()->patient;
        
        $paiementsEnAttente = Paiement::where('patientId', $patient->id)
                            ->whereIn('statut', ['en attente', 'en cours'])
                            ->orderBy('date', 'desc')
                            ->get();
                            
        $paiementsEffectues = Paiement::where('patientId', $patient->id)
                            ->where('statut', 'payé')
                            ->orderBy('date', 'desc')
                            ->paginate(10);
        
        return view('patient.paiements.index', compact('paiementsEnAttente', 'paiementsEffectues'));
    }
    
    /**
     * Affiche le formulaire pour effectuer un paiement.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\View\View
     */
    public function effectuer(Consultation $consultation)
    {
        // Vérifier que la consultation appartient bien au patient connecté
        if ($consultation->patientId != Auth::user()->patient->id) {
            abort(403);
        }
        
        $paiement = Paiement::where('consultationId', $consultation->id)
                            ->whereIn('statut', ['en attente', 'en cours'])
                            ->firstOrFail();
        
        return view('patient.paiements.effectuer', compact('paiement', 'consultation'));
    }
    
    /**
     * Traite le paiement.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\RedirectResponse
     */
    public function traiter(Request $request, Paiement $paiement)
    {
        // Vérifier que le paiement appartient bien au patient connecté
        if ($paiement->patientId != Auth::user()->patient->id) {
            abort(403);
        }
        
        $request->validate([
            'methode' => 'required|in:MobileMoney,Carte',
            // Autres validations selon la méthode de paiement
        ]);
        
        // Logique de traitement du paiement
        // Dans un cas réel, vous intégreriez ici une passerelle de paiement
        
        $paiement->update([
            'methode' => $request->methode,
            'statut' => 'payé',
            'date' => now(),
        ]);
        
        // Si le paiement concerne une consultation, mettre à jour son statut
        if ($paiement->consultationId) {
            $consultation = Consultation::find($paiement->consultationId);
            if ($consultation) {
                $consultation->update(['statut' => 'confirmé']);
            }
        }
        
        return redirect()->route('paiements.index')
                        ->with('success', 'Paiement effectué avec succès!');
    }
    
    /**
     * Génère un reçu de paiement.
     *
     * @param  \App\Models\Paiement  $paiement
     * @return \Illuminate\Http\Response
     */
    public function recu(Paiement $paiement)
    {
        // Vérifier que le paiement appartient bien au patient connecté
        if ($paiement->patientId != Auth::user()->patient->id) {
            abort(403);
        }
        
        // Générer le PDF du reçu
        $pdf = PDF::loadView('patient.paiements.recu', compact('paiement'));
        
        return $pdf->download('recu-paiement-' . $paiement->id . '.pdf');
    }
}