<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'id_utilisateurs';

    protected $fillable = [
        'nom',
        'prenoms',
        'email',
        'telephone',
        'mot_de_passe',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_utilisateurs');
    }
}
