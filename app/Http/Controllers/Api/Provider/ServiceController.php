<?php

namespace App\Http\Controllers\Api\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NunoMaduro\Collision\Provider;

class ServiceController extends Controller
{
    public function index()
    {
        $provider = Auth::user()->provider;

        if (!$provider) {
            return response()->json(['message' => 'Prestataire non trouvé'], 404);
        }

        return response()->json($provider->services);
    }
}
