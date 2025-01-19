<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    
    public function index()
    {
       $client = Auth::user()->client;
    

        // Vérifier si le client existe
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client non trouvé pour cet utilisateur.',
            ], 404);
        }

        // Récupérer toutes les réservations du client
        $reservations = Reservation::with(['client', 'prestataire', 'service'])
        ->where('client_id', $client->id) // Filtrer par l'ID du client
        ->get();

        // Vérifier si le client a des réservations
        if ($reservations->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune réservation trouvée pour ce client.',
            ], 404);
        }

        // Retourner les réservations du client
        return response()->json([
            'success' => true,
            'data' => $reservations,
        ], 200);
   }

    
}
