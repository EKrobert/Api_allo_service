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
            // Récupérer l'utilisateur connecté
            $user = Auth::user();

            // Vérifier si l'utilisateur est un prestataire
            if (!$user || !$user->prestataire) {
                return response()->json([
                    'success' => false,
                    'message' => 'Utilisateur non trouvé ou non prestataire.',
                ], 404);
            }

            // Récupérer le prestataire associé à l'utilisateur
            $prestataire = $user->prestataire;

            // Récupérer les IDs des services auxquels le prestataire est déjà abonné
            $subscribedServiceIds = $prestataire->services()->pluck('services.id');

            // Récupérer tous les services disponibles
            $allServices = Service::all();

            // Filtrer les services non abonnés
            $unsubscribedServices = $allServices->reject(function ($service) use ($subscribedServiceIds) {
                return $subscribedServiceIds->contains($service->id);
            });

            // Vérifier s'il y a des services non abonnés
            if ($unsubscribedServices->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Le prestataire est abonné à tous les services disponibles.',
                    'data' => [],
                ], 200);
            }

            // Retourner les services non abonnés
            return response()->json([
                'success' => true,
                'message' => 'Services non abonnés récupérés avec succès.',
                'data' => $unsubscribedServices,
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

    public function getSubscribedServices()
    {
        // Récupérer le prestataire authentifié
        $prestataire = Auth::user()->prestataire;

        // Récupérer les services auxquels le prestataire s'est abonné avec le prix
        $services = $prestataire->services()->withPivot('prix')->get();

        // Retourner la réponse JSON
        return response()->json(['services' => $services], 200);
    }


    public function updateServicePrice(Request $request, $serviceId)
    {

        $validator = Validator::make($request->all(), [
            'prix' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $prestataire = Auth::user()->prestataire;
        $prestataire->services()->updateExistingPivot($serviceId, ['prix' => $data['prix']]);
        return response()->json(['message' => 'Prix mis à jour avec succès'], 200);
    }
}
