<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consultation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patientId',
        'medecinId',
        'date',
        'type',
        'notes',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the patient associated with the consultation.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    /**
     * Get the medecin who performed the consultation.
     */
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecinId');
    }

    /**
     * Get the prescription associated with the consultation.
     */
    public function ordonnance()
    {
        return $this->hasOne(Ordonnance::class, 'consultationId');
    }

    /**
     * Get the payment associated with the consultation.
     */
    public function paiement()
    {
        return $this->hasOne(Paiement::class, 'consultationId');
    }

    /**
     * Check if consultation is pending
     */
    public function isPending()
    {
        return $this->statut === 'en attente';
    }

    /**
     * Check if consultation is completed
     */
    public function isCompleted()
    {
        return $this->statut === 'terminée';
    }

    /**
     * Check if consultation is canceled
     */
    public function isCanceled()
    {
        return $this->statut === 'annulée';
    }
}