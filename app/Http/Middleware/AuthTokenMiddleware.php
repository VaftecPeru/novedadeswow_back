<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UsuarioToken;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        // Validar header
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return response()->json([
                'error' => 'Token no proporcionado',
                'code' => 'TOKEN_MISSING'
            ], 401, [], JSON_UNESCAPED_UNICODE);
        }

        $token = $matches[1];

        $usuarioToken = UsuarioToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->with(['usuario.rol'])
            ->first();

        if (!$usuarioToken) {
            return response()->json([
                'error' => 'Token inválido o expirado',
                'code' => 'TOKEN_INVALID'
            ], 401, [], JSON_UNESCAPED_UNICODE);
        }

        $request->merge(['user' => $usuarioToken->usuario]);
        Auth::setUser($usuarioToken->usuario);

        return $next($request);
    }
}