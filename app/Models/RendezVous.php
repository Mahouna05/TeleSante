<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rendez_vous';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patientId',
        'medecinId',
        'motif',
        'moyen',
        'dateHeure',
        'tarif',
        'statut',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dateHeure' => 'datetime',
    ];

    /**
     * Get the patient associated with the appointment.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    /**
     * Get the medecin associated with the appointment.
     */
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecinId');
    }

    /**
     * Check if appointment is pending
     */
    public function isPending()
    {
        return $this->statut === 'en attente';
    }

    /**
     * Check if appointment is confirmed
     */
    public function isConfirmed()
    {
        return $this->statut === 'confirmé';
    }

    /**
     * Check if appointment is canceled
     */
    public function isCanceled()
    {
        return $this->statut === 'annulé';
    }
}