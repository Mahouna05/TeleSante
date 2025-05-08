<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\RendezVous;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConsultationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $patient = $user->patient;
        
        $consultationsAVenir = Consultation::where('patientId', $patient->id)
            ->where('date', '>', Carbon::now())
            ->orderBy('date', 'asc')
            ->get();
            
        $consultationsPassees = Consultation::where('patientId', $patient->id)
            ->where('date', '<', Carbon::now())
            ->orderBy('date', 'desc')
            ->get();
            
            return view('patient.consultations.index', compact('consultationsAVenir', 'consultationsPassees'));
        }
        
        public function show(Consultation $consultation)
        {
            $this->authorize('view', $consultation);
            return view('patient.consultations.show', compact('consultation'));
        }
        
        public function join(RendezVous $rendezVous)
        {
            $this->authorize('join', $rendezVous);
            
            // Vérifier si la consultation est programmée pour maintenant
            $now = Carbon::now();
            $consultationTime = Carbon::parse($rendezVous->dateHeure);
            
            if ($now->diffInMinutes($consultationTime, false) > 15) {
                return redirect()->route('consultations.index')
                    ->with('error', 'La consultation n\'est pas encore disponible. Elle sera accessible 15 minutes avant l\'heure prévue.');
            }
            
            // Déterminer le type de consultation (vidéo, audio, chat)
            $type = $rendezVous->consultation->type ?? 'video';
            
            if ($type == 'video' || $type == 'audio') {
                return view('patient.consultations.video-call', compact('rendezVous'));
            } else {
                return view('patient.consultations.chat', compact('rendezVous'));
            }
        }
        
        public function reschedule(Request $request, Consultation $consultation)
        {
            $this->authorize('reschedule', $consultation);
            
            $request->validate([
                'dateHeure' => 'required|date|after:now',
            ]);
            
            $rendezVous = $consultation->rendezVous;
            $rendezVous->dateHeure = $request->dateHeure;
            $rendezVous->statut = 'en attente';
            $rendezVous->save();
            
            // Notification au médecin
            $consultation->medecin->user->notify(new ConsultationRescheduled($consultation));
            
            return redirect()->route('consultations.index')
                ->with('success', 'Votre consultation a été reprogrammée et est en attente de confirmation.');
        }
        
        public function cancel(Consultation $consultation)
        {
            $this->authorize('cancel', $consultation);
            
            $rendezVous = $consultation->rendezVous;
            $rendezVous->statut = 'annulé';
            $rendezVous->save();
            
            // Notification au médecin
            $consultation->medecin->user->notify(new ConsultationCancelled($consultation));
            
            return redirect()->route('consultations.index')
                ->with('success', 'Votre consultation a été annulée.');
        }
    }