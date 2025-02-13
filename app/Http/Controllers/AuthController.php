<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use Illuminate\Http\JsonResponse;

/**
 * @group Auth
 *
 * API endpoints for managing auth
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * @bodyParam email string required
     * @bodyParam password string required minimum character length is 6
     *
     * @responseFile 200 resources/responses/Auth/login.json
     */
    public function login(AuthLoginRequest $request): JsonResponse {
        return response()->json();
    }

    /**
     * Register
     *
     * @bodyParam name string required
     * @bodyParam email string required
     * @bodyParam password string required
     * @bodyParam password_confirmation string required
     *
     * @responseFile 201 resources/responses/Auth/register.json
     */
    public function register(AuthRegisterRequest $request): JsonResponse {
        return response()->json();
    }

    /**
     * Logout
     *
     * @authenticated
     */
    public function logout(): JsonResponse {
        return response()->json();
    }
}
