<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use App\Models\Notification;
use App\Models\DossierMedical;
use App\Models\Ordonnance;
use Carbon\Carbon;

class DashboardPatientController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        // Récupérer les rendez-vous à venir
        $rendezVous = RendezVous::where('patientId', $patient->id)
            ->where('dateHeure', '>', Carbon::now())
            ->where('statut', 'confirmé')
            ->orderBy('dateHeure', 'asc')
            ->take(3)
            ->get();
        
        // Récupérer les notifications non lues
        $notifications = Notification::where('utilisateur_id', $user->id)
            ->where('lu', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Récupérer les rappels de médicaments
        $ordonnances = Ordonnance::whereHas('consultation', function($query) use ($patient) {
            $query->where('patientId', $patient->id);
        })->with('medicaments')->get();
        
        $prochainBilan = DossierMedical::where('patientId', $patient->id)
            ->first();
            
        return view('dashboard.index', compact('rendezVous', 'notifications', 'ordonnances', 'prochainBilan'));
    }
}