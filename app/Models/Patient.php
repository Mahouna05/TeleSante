<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'patient';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'dateNaissance',
        'groupeSanguin',
        'taille',
        'poids',
        'profession',
        'sexe',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'dateNaissance' => 'date',
    ];
    
    /**
     * Get the user that owns the patient.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the dossier medical for the patient.
     */
    public function dossierMedical()
    {
        return $this->hasOne(DossierMedical::class, 'patientId');
    }
    
    /**
     * Get the consultations for the patient.
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'patientId');
    }
    
    /**
     * Get the ordonnances for the patient.
     */
    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class, 'patientId');
    }
    
    /**
     * Get the rendez-vous for the patient.
     */
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'patientId');
    }
    
    /**
     * Get the paiements for the patient.
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'patientId');
    }
    
    /**
     * Get the messages sent by the patient.
     */
    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'senderId');
    }
    
    /**
     * Get the evaluations made by the patient.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'patientId');
    }
    
    /**
     * Get the commandes made by the patient.
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'patientId');
    }
    
    /**
     * Get the medicaments for the patient.
     */
    public function medicaments()
    {
        return $this->hasMany(Medicament::class, 'patientId');
    }
}