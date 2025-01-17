<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        // Règles de validation
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|unique:users,username|min:5|max:15',
            'password' => 'required',
        ]);
    
        // Vérification des erreurs de validation
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 400);
        }
    
        try {
            $data = $request->all();
            $data['password'] =  bcrypt($request->password); // Hachage du mot de passe
            // Création de l'utilisateur
            $user = User::create($data);
            // Réponse en cas de succès
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => $user,
            ], 201);
        } catch (\Exception $e) {
            // Gestion des erreurs inattendues
            return response()->json([
                'success' => false,
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
