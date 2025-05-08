<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Medicament extends Model
{
    use HasFactory;
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medicament';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'dose',
        'date_début',
        'date_fin',
        'patientId',
        'ordonnanceId',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_début' => 'date',
        'date_fin' => 'date',
    ];

    /**
     * Get the patient associated with the medication.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientId');
    }

    /**
     * Get the prescription associated with the medication.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ordonnance()
    {
        return $this->belongsTo(Ordonnance::class, 'ordonnanceId');
    }

    /**
     * Get the orders for this medication.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'medicamentId');
    }

    /**
     * Check if medication is currently active
     *
     * @return bool
     */
    public function isActive()
    {
        $now = Carbon::now()->startOfDay();
        return $now->between($this->date_début, $this->date_fin);
    }

    /**
     * Get the remaining days of treatment
     *
     * @return int
     */
    public function getRemainingDaysAttribute()
    {
        $now = Carbon::now()->startOfDay();
        if ($now->gt($this->date_fin)) {
            return 0;
        }
        return $now->diffInDays($this->date_fin);
    }

    /**
     * Get the total duration of treatment in days
     *
     * @return int
     */
    public function getTotalDurationAttribute()
    {
        return $this->date_début->diffInDays($this->date_fin);
    }

    /**
     * Check if medication treatment is complete
     *
     * @return bool
     */
    public function isComplete()
    {
        return Carbon::now()->startOfDay()->gt($this->date_fin);
    }

    /**
     * Check if medication treatment has started
     *
     * @return bool
     */
    public function hasStarted()
    {
        return Carbon::now()->startOfDay()->gte($this->date_début);
    }

    /**
     * Get the formatted dose with unit
     *
     * @return string
     */
    public function getFormattedDoseAttribute()
    {
        return $this->dose;
    }

    /**
     * Get percentage of treatment completed
     *
     * @return int
     */
    public function getProgressPercentageAttribute()
    {
        $totalDays = $this->getTotalDurationAttribute();
        if ($totalDays == 0) {
            return 100; // Avoid division by zero
        }

        $now = Carbon::now()->startOfDay();
        
        // If not started yet
        if ($now->lt($this->date_début)) {
            return 0;
        }
        
        // If completed
        if ($now->gt($this->date_fin)) {
            return 100;
        }
        
        // Calculate progress
        $daysElapsed = $this->date_début->diffInDays($now);
        return min(100, round(($daysElapsed / $totalDays) * 100));
    }

    /**
     * Scope query to only include active medications
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        $now = Carbon::now()->format('Y-m-d');
        return $query->where('date_début', '<=', $now)
                     ->where('date_fin', '>=', $now);
    }

    /**
     * Scope query to only include expired medications
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpired($query)
    {
        $now = Carbon::now()->format('Y-m-d');
        return $query->where('date_fin', '<', $now);
    }

    /**
     * Scope query to only include future medications (not started yet)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFuture($query)
    {
        $now = Carbon::now()->format('Y-m-d');
        return $query->where('date_début', '>', $now);
    }
}