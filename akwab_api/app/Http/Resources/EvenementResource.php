<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvenementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->id_evenement,
            'nom'                      => $this->nom,
            'lieu'                     => $this->lieu,
            'date'                     => $this->date,
            'description'              => $this->description,
            'prix_ticket'              => $this->prix_ticket,
            'nombre_ticket_disponible' => $this->nombre_ticket_disponible,
            'image'                    => $this->image,
            'categorie'                => $this->categorie,
        ];
    }
}
