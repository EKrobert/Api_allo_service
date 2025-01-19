<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $provider = Auth::user()->provider;

        // Vérifier si le prestataire existe
        if (!$provider) {
            return response()->json([
                'success' => false,
                'message' => 'Prestataire non trouvé pour cet utilisateur.',
            ], 404);
        }

        // Récupérer toutes les réservations du prestataire
        $reservations = Reservation::with(['client', 'prestataire', 'service'])
            ->where('prestataire_id', $provider->id) // Filtrer par l'ID du prestataire
            ->get();

        // Vérifier si le prestataire a des réservations
        if ($reservations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune réservation trouvée pour ce prestataire.',
            ], 404);
        }

        // Retourner les réservations du prestataire
        return response()->json([
            'success' => true,
            'data' => $reservations,
        ], 200);
    }
}
