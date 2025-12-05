<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Service\AuthService;
use Exception;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function signIn(LoginRequest $loginRequest){
        $validated_input = $loginRequest->validated();

        try {
            $token = $this->authService->signIn($validated_input);

            return response()->json(['token' => $token], 200) ;
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Error',
                'status' => 400,
                'detail' => $exception->getMessage()
            ], 400);
        }
    }
}
