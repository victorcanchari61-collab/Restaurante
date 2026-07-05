<?php

namespace App\Services;

class AuthService
{
    /**
     * Intenta autenticar y devuelve el token JWT, o null si las credenciales fallan.
     */
    public function attemptLogin(array $credentials): ?string
    {
        $token = auth('api')->attempt($credentials);

        return $token ?: null;
    }

    public function logout(): void
    {
        auth('api')->logout();
    }

    public function refresh(): string
    {
        return auth('api')->refresh();
    }

    /**
     * Estructura estándar de respuesta para un token emitido.
     */
    public function tokenPayload(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];
    }
}
