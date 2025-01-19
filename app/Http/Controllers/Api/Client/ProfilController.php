<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return response()->json([
            'success' => true,
            'message' => 'Profil récupéré avec succès.',
            'data' => $user,
        ], 200);
    }
}
