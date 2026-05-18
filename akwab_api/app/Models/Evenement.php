<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    protected $table = 'evenements';
    protected $primaryKey = 'id_evenement';

    protected $fillable = [
        'nom',
        'lieu',
        'date',
        'description',
        'prix_ticket',
        'nombre_ticket_disponible',
        'image',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_evenement');
    }
}
