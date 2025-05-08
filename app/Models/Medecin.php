<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medecin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'specialite',
        'numeroProfessionnel',
        'experience',
    ];

    /**
     * Get the user record associated with the medecin.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the consultations for the medecin.
     */
    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'medecinId');
    }

    /**
     * Get the prescriptions written by the medecin.
     */
    public function ordonnances()
    {
        return $this->hasMany(Ordonnance::class, 'medecinId');
    }

    /**
     * Get the appointments for the medecin.
     */
    public function rendezVous()
    {
        return $this->hasMany(RendezVous::class, 'medecinId');
    }

    /**
     * Get the payments received by the medecin.
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'medecinId');
    }

    /**
     * Get messages received by the medecin.
     */
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiverId');
    }

    /**
     * Get the evaluations received by the medecin.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'medecinId');
    }

    /**
     * Get the average rating for the medecin.
     */
    public function getAverageRatingAttribute()
    {
        return $this->evaluations()->avg('note') ?? 0;
    }
}