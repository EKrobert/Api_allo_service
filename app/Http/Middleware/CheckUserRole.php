<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
         // Vérifier si l'utilisateur est authentifié
         if (!$request->user()) {
            return response()->json(['message' => 'Non authentifié.'], 401);
        }

        // Vérifier si l'utilisateur a le rôle requis
        if ($request->user()->role !== $role) {
            return response()->json(['message' => 'Accès interdit.'], 403);
        }
        return $next($request);
    }
}
