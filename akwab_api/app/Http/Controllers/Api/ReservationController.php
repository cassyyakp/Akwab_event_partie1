<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategorieRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateCategorieRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Evenement;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Reservation::with(['evenement', 'utilisateur'])
            ->where('id_utilisateurs', $request->user()->getKey())
            ->orderBy('created_at', 'desc');

        if ($user->id_role !== 1) {
            $query->where('id_utilisateurs', $user->getKey());
        }

        $reservations = $query->paginate(10);


        return ReservationResource::collection($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {

        $evenement = Evenement::findOrFail($request->id_evenement);

        if ($evenement->nombre_ticket_disponible < $request->nombre_ticket_pris) {
            return response()->json([
                'success' => false,
                'message' => 'Nombre de tickets insuffisant'
            ], 422);
        }

        DB::transaction(function () use ($request, $evenement, &$reservation) {
            $prixTotal = $evenement->prix_ticket * $request->nombre_ticket_pris;
            $reservation = Reservation::create([
                'date_reservation' => now(),
                'nombre_ticket_pris' => $request->nombre_ticket_pris,
                'prix_total' => $prixTotal,
                'id_utilisateurs' => $request->user()->getKey(),
                'id_evenement' => $request->id_evenement
            ]);
            $evenement->decrement('nombre_ticket_disponible', $request->nombre_ticket_pris);
        });

        return new ReservationResource($reservation);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $reservation = Reservation::with(['evenement', 'utilisateur'])->findOrFail($id);

        return new ReservationResource($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReservationRequest $request, string $id)
    {
        $reservation = Reservation::findOrFail($id);

        $evenement = $reservation->evenement;

        $difference = $request->nombre_ticket_pris - $reservation->nombre_ticket_pris;
        $evenement->increment('nombre_ticket_disponible', $reservation->nombre_ticket_pris);

        if ($difference > 0 && $evenement->nombre_ticket_disponible < $difference) {
            return response()->json([
                'message' => 'Nombre de tickets insuffisant'
            ], 422);
        }

        DB::transaction(function () use ($request, $evenement, $reservation) {
            $prixTotal = $evenement->prix_ticket * $request->nombre_ticket_pris;

            $reservation->update([
                'nombre_ticket_pris' => $request->nombre_ticket_pris,
                'prix_total' => $prixTotal
            ]);
            $evenement->decrement('nombre_ticket_disponible', $request->nombre_ticket_pris);
        });

        return new ReservationResource($reservation->fresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);

        DB::transaction(function () use ($reservation) {
            $reservation->evenement->increment('nombre_ticket_disponible', $reservation->nombre_ticket_pris);
            $reservation->delete();
        });
        return response()->json([
            'success' => true,
            'message' => 'Réservation supprimée avec succès'
        ], 200);
    }
}
