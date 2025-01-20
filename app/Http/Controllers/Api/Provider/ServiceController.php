<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use App\Models\Prestataire;
use App\Models\PrestataireService;
use App\Models\Service;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use NunoMaduro\Collision\Provider;

class ServiceController extends Controller
{
    public function index()
    {
        try {
            // Récupérer tous les services disponibles
            $services = Service::all();
            // Vérifier si des services ont été trouvés
            if ($services->isEmpty()) {
                return response()->json([
                    'message' => 'Aucun service disponible',
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => 'Services récupérés avec succès',
                'data' => $services,
            ], 200);
        } catch (ModelNotFoundException $e) {
            // Gestion spécifique pour les erreurs de modèle (si un service est introuvable)
            return response()->json([
                'error' => 'Aucun service trouvé.',
                'message' => $e->getMessage(),
            ], 404);
        } catch (Exception $e) {
            // Gestion des erreurs générales
            return response()->json([
                'error' => 'Une erreur est survenue lors de la récupération des services.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function providerService(Request $request)
    {
        // Validation des données entrantes
        $validator = Validator::make($request->all(), [
            // 'prestataire_id' => 'required|exists:prestataires,id',
            'service_id' => 'required|exists:services,id',
            'prix' => 'required|numeric|min:0',
        ]);

        // Si la validation échoue, retourner une réponse d'erreur
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $prestataire = Auth::user()->prestataire;
        // Attacher le service au prestataire avec le prix
        $prestataire->services()->attach($data['service_id'], ['prix' => $data['prix']]);
        // Retourner une réponse de succès
        return response()->json(['message' => 'Service ajouté avec succès'], 200);
    }


    public function getPrestataireServices()
    {
        // Récupérer l'utilisateur authentifié
        $user = Auth::user();

        // Vérifier si l'utilisateur est un prestataire
        if (!$user->prestataire) {
            return response()->json(['message' => 'Cet utilisateur n\'est pas un prestataire'], 404);
        }

        // Récupérer le prestataire associé à l'utilisateur
        $prestataire = $user->prestataire;
        
        // Récupérer les services du prestataire avec le prix (depuis la table pivot)
        $services = $prestataire->services;

        
        // Formater la réponse pour inclure les détails du service et le prix
        $formattedServices = $services->map(function ($service) {
            return [
                'id' => $service->id, // ID du service (depuis la table services)
                'nom' => $service->name, // Nom du service (depuis la table services)
                'prix' => $service->pivot->prix, // Prix du service (depuis la table pivot prestataire_service)
            ];
        });

        // Retourner les services dans la réponse
        return response()->json([
            'success' => true,
            'message' => 'Services récupérés avec succès',
            'data' => $formattedServices,
        ], 200);
    }
}
