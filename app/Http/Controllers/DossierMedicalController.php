<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use App\Models\Consultation;
use Illuminate\Http\Request;
use PDF;

class DossierMedicalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        $dossier = DossierMedical::where('patientId', $patient->id)->first();
        
        if (!$dossier) {
            // Créer un dossier médical s'il n'existe pas
            $dossier = new DossierMedical();
            $dossier->patient_id = $patient->id;
            $dossier->date_creation = now();
            $dossier->save();
        }
        
        $consultations = Consultation::where('patientId', $patient->id)
            ->where('statut', 'terminé')
            ->orderBy('date', 'desc')
            ->get();
        
        return view('patient.dossier-medical.index', compact('dossier', 'consultations'));
    }
    
    public function details()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        $dossier = DossierMedical::where('patientId', $patient->id)->first();
        
        if (!$dossier) {
            return redirect()->route('dossier-medical.index');
        }
        
        return view('patient.dossier-medical.details', compact('dossier'));
    }
    
    public function showConsultation(Consultation $consultation)
    {
        $this->authorize('view', $consultation);
        
        return view('patient.dossier-medical.consultation', compact('consultation'));
    }
    
    public function telecharger()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        $dossier = DossierMedical::where('patientId', $patient->id)->first();
        
        if (!$dossier) {
            return redirect()->route('dossier-medical.index')
                ->with('error', 'Dossier médical non disponible.');
        }
        
        $consultations = Consultation::where('patientId', $patient->id)
            ->where('statut', 'terminé')
            ->orderBy('date', 'desc')
            ->get();
        
        $pdf = PDF::loadView('patient.dossier-medical.pdf.dossier', compact('dossier', 'consultations', 'patient'));
        
        return $pdf->download('dossier_medical_' . $patient->id . '.pdf');
    }
}