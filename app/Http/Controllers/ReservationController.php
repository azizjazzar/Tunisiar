<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vol;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with('vol', 'user')->get();
        return response()->json($reservations);
    }

    public function list_reservations()
    {
        $user = auth()->user();
        $reservations = Reservation::where('user_id', $user->id)->with('vol', 'user')->get();
        return response()->json($reservations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function reservation(Request $request, Vol $vol)
    {
        $request->validate([
            'nbr_place' => 'required|integer|min:1', // Assurez-vous que nbr_place est un entier positif
        ]);

        $volPrice = $vol->price;

        $reservationPrice = $request->nbr_place * $volPrice;

        $user_id = auth()->id();

        $reservationData = [
            'nbr_place' => $request->nbr_place,
            'vol_id' => $vol->id,
            'price' => $reservationPrice, // Ajoutez le prix de la réservation
        ];

        if ($user_id !== null) {
            $reservationData['user_id'] = $user_id;
        }

        Reservation::create($reservationData);

        return response()->json(['message' => 'Reservation successful'], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        return response()->json($reservation);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'nbr_place' => 'required|integer|min:1',
        ]);

        $reservation->update([
            'nbr_place' => $request->nbr_place,
        ]);

        return response()->json(['message' => 'Reservation updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully'], 200);
    }
}
