<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_reservation' => $this->id_reservation,
            'date_reservation' => $this->date_reservation,
            'nombre_ticket_pris' => $this->nombre_ticket_pris,
            'prix_total' => $this->prix_total,

            'utilisateur' => [
                'nom' => $this->utilisateur->nom,
                'prenoms' => $this->utilisateur->prenoms,
            ],

            'evenement' => [
                'nom' => $this->evenement->nom,
                'lieu' => $this->evenement->lieu,
                'date' => $this->evenement->date,
            ],
        ];
    }
}
