<?php

namespace App\Models;

use Hamcrest\Util;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Reservation extends Model
{
    /** @use HasFactory<\Database\Factories\ReservationFactory> */
    use HasFactory;

    protected $table = 'reservations';

    protected $primaryKey = 'id_reservation';

    protected $fillable = [
        'date_reservation',
        'nombre_ticket_pris',
        'prix_total',
        'id_utilisateurs',
        'id_evenement'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateurs');
    }

    public function evenement()
    {
        return $this->belongsTo(Evenement::class, 'id_evenement');
    }
}
