<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    use HasFactory;
  /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ordonnance';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'consultationId',
        'patientId',
        'medecinId',
        'medicament',
        'dose',
        'durée',
        'instructions',
        'dateCréation',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dateCréation' => 'datetime',
    ];

    /**
     * Get the consultation that resulted in this prescription.
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultationId');
    }

    /**
     * Get the patient who received the prescription.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    /**
     * Get the medecin who wrote the prescription.
     */
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecinId');
    }

    /**
     * Get the medications associated with this prescription.
     */
    public function medicaments()
    {
        return $this->hasMany(Medicament::class, 'ordonnanceId');
    }
}