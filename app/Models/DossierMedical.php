<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dossier_medical';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patientId',
        'antécédents_chroniques',
        'allergies',
        'pathologies',
        'vaccinations',
        'symptomes_decrits',
        'resultats_examens',
        'traitements',
        'medicaments_prescrits',
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
     * Get the patient that owns the medical record.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }
}