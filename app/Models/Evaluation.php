<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'evaluation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patientId',
        'medecinId',
        'note',
        'commentaire',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'note' => 'integer',
        'date' => 'datetime',
    ];

    /**
     * Get the patient who made the evaluation.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    /**
     * Get the medecin who was evaluated.
     */
    public function medecin()
    {
        return $this->belongsTo(Medecin::class, 'medecinId');
    }
}