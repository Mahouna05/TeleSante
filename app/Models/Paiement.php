<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paiement';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'consultationId',
        'medecinId',
        'patientId',
        'montant',
        'méthode',
        'statut',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'montant' => 'decimal:2',
        'date' => 'datetime',
    ];

    /**
     * Get the consultation associated with the payment.
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultationId');
    }

    /**
     * Get the medecin who received the payment.
     */
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecinId');
    }

    /**
     * Get the patient who made the payment.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->statut === 'en attente';
    }

    /**
     * Check if payment is completed
     */
    public function isCompleted()
    {
        return $this->statut === 'effectué';
    }

    /**
     * Check if payment failed
     */
    public function isFailed()
    {
        return $this->statut === 'échoué';
    }
}