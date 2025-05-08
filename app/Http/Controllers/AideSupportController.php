<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\SupportMessage;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SupportMessageReceived;
use Illuminate\Support\Facades\Storage;

class AideSupportController extends Controller
{
    /**
     * Afficher la page d'aide et support
     */
    public function index()
    {
        // Récupérer les FAQ
        $faqs = Faq::where('statut', 'actif')->orderBy('ordre')->get();
        
        // Récupérer les messages de support récents de l'utilisateur
        $user = Auth::user();
        $supportMessages = SupportMessage::where('utilisateur_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        return view('patient.aide-support.index', compact('faqs', 'supportMessages'));
    }
    
    /**
     * Afficher le guide complet d'utilisation
     */
    public function guideComplet()
    {
        // Charger éventuellement le document du guide
        $guide = Document::where('type', 'guide_utilisation')
            ->where('statut', 'actif')
            ->first();
            
        return view('patient.aide-support.guide-complet', compact('guide'));
    }
    
    /**
     * Afficher une FAQ spécifique
     */
    public function showFaq($id)
    {
        $faq = Faq::findOrFail($id);
        return view('patient.aide-support.faq-detail', compact('faq'));
    }
    
    /**
     * Afficher la page de contact avec le support
     */
    public function contactSupport()
    {
        return view('patient.aide-support.contact');
    }
    
    /**
     * Envoyer un message au support
     */
    public function envoyerMessage(Request $request)
    {
        $request->validate([
            'sujet' => ['required', 'string', 'in:question,probleme_technique,rendez_vous,paiement,suggestion,autre'],
            'message' => ['required', 'string', 'min:10'],
            'screenshot' => ['nullable', 'file', 'mimes:jpeg,png,gif', 'max:2048'],
        ]);
        
        $user = Auth::user();
        
        $supportMessage = new SupportMessage();
        $supportMessage->utilisateur_id = $user->id;
        $supportMessage->sujet = $request->sujet;
        $supportMessage->message = $request->message;
        $supportMessage->statut = 'nouveau';
        
        // Traiter la capture d'écran si présente
        if ($request->hasFile('screenshot')) {
            $filename = time() . '.' . $request->screenshot->extension();
            $path = $request->screenshot->storeAs('public/support', $filename);
            $supportMessage->screenshot = $filename;
        }
        
        $supportMessage->save();
        
        // Envoi d'un e-mail de confirmation
        try {
            // Envoyer un email au support
            Mail::to(config('app.support_email'))->send(new SupportMessageReceived($supportMessage));
            
            // Envoyer une confirmation à l'utilisateur
            // Mail::to($user->email)->send(new SupportMessageConfirmation($supportMessage));
            
            Log::info('Message de support envoyé', ['user_id' => $user->id, 'message_id' => $supportMessage->id]);
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi d\'email de support', ['error' => $e->getMessage()]);
        }
        
        return redirect()->route('patient.aide-support.index')
            ->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
    
    /**
     * Afficher les messages de support de l'utilisateur
     */
    public function mesMessages()
    {
        $user = Auth::user();
        $messages = SupportMessage::where('utilisateur_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('patient.aide-support.mes-messages', compact('messages'));
    }
    
    /**
     * Afficher un message de support spécifique
     */
    public function showMessage($id)
    {
        $user = Auth::user();
        $message = SupportMessage::where('id', $id)
            ->where('utilisateur_id', $user->id)
            ->firstOrFail();
            
        return view('patient.aide-support.message-detail', compact('message'));
    }
    
    /**
     * Afficher les politiques et conditions d'utilisation
     */
    public function politiques($type = 'confidentialite')
    {
        $types = [
            'confidentialite' => 'Politique de confidentialité',
            'conditions' => 'Conditions d\'utilisation',
            'mentions' => 'Mentions légales',
        ];
        
        if (!array_key_exists($type, $types)) {
            abort(404);
        }
        
        $document = Document::where('type', $type)
            ->where('statut', 'actif')
            ->first();
            
        $titre = $types[$type];
        
        return view('patient.aide-support.politiques', compact('document', 'titre', 'type'));
    }
}