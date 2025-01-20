<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Reservation extends Model
{
    use Notifiable;

    protected $fillable = [
        'client_id',
        'prestataire_id',
        'service_id',
        'statut',
        'reservation_date',
    ];

    // Relation avec le Prestataire
    public function prestataire(): BelongsTo
    {
        return $this->belongsTo(Prestataire::class);
    }
    // Relation avec le Service
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    // Relation avec le client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
