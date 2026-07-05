<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->attemptLogin(
            $request->only('email', 'password'),
        );

        if ($token === null) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($this->authService->tokenPayload($token));
    }

    public function me(): JsonResponse
    {
        return response()->json(
            new UserResource(auth('api')->user()),
        );
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        return response()->json(
            $this->authService->tokenPayload($this->authService->refresh()),
        );
    }
}
