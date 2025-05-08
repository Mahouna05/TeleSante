<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'senderId',
        'receiverId',
        'dateEnvoi',
        'contenu',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'dateEnvoi' => 'datetime',
    ];

    /**
     * Get the patient who sent the message.
     */
    public function sender()
    {
        return $this->belongsTo(Patient::class, 'senderId');
    }

    /**
     * Get the medecin who received the message.
     */
    public function receiver()
    {
        return $this->belongsTo(Medecin::class, 'receiverId');
    }
}