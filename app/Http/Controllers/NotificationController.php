<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Affiche la liste des notifications du patient.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        
        $notifications = Notification::where('utilisateurId', $user->id)
                                    ->orderBy('dateEnvoi', 'desc')
                                    ->paginate(15);
        
        // Marquer toutes les notifications non lues comme lues
        Notification::where('utilisateurId', $user->id)
                    ->where('lu', false)
                    ->update(['lu' => true]);
        
        return view('patient.notifications.index', compact('notifications'));
    }
    
    /**
     * Marque une notification comme lue.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function marquerCommeLu(Notification $notification)
    {
        // Vérifier que la notification appartient bien à l'utilisateur connecté
        if ($notification->utilisateurId != Auth::id()) {
            abort(403);
        }
        
        $notification->update(['lu' => true]);
        
        return back();
    }
    
    /**
     * Supprime une notification.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\RedirectResponse
     */
    public function supprimer(Notification $notification)
    {
        // Vérifier que la notification appartient bien à l'utilisateur connecté
        if ($notification->utilisateurId != Auth::id()) {
            abort(403);
        }
        
        $notification->delete();
        
        return back()->with('success', 'Notification supprimée avec succès');
    }
    
    /**
     * Marque toutes les notifications comme lues.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toutMarquerCommeLu()
    {
        Notification::where('utilisateurId', Auth::id())
                  ->where('lu', false)
                  ->update(['lu' => true]);
        
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues');
    }
    
    /**
     * Supprime toutes les notifications.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toutSupprimer()
    {
        Notification::where('utilisateurId', Auth::id())->delete();
        
        return back()->with('success', 'Toutes les notifications ont été supprimées');
    }
    
    /**
     * Récupère le nombre de notifications non lues (pour l'affichage dans le menu)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function compteurNonLues()
    {
        $count = Notification::where('utilisateurId', Auth::id())
                           ->where('lu', false)
                           ->count();
        
        return response()->json(['count' => $count]);
    }
}