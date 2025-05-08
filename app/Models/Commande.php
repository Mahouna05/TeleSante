<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patientId',
        'medicamentId',
        'prix',
        'indice',
        'option',
        'montant_total',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'prix' => 'integer',
        'montant_total' => 'integer',
    ];

    /**
     * Get the patient who placed the order.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    /**
     * Get the medication associated with the order.
     */
    public function medicament()
    {
        return $this->belongsTo(Medicament::class, 'medicamentId');
    }

    /**
     * Check if this is an express order
     */
    public function isExpress()
    {
        return $this->option === 'express';
    }
}