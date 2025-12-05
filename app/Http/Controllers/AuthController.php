<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
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

    public function signUp(SignUpRequest $signUpRequest){
        $validated_signup = $signUpRequest->validated();

        try {
            $teacher = $this->authService->signUp($validated_signup);

            return response()->json([
                'data' => $teacher
            ], 201);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Error',
                'status' => 400,
                'detail' => $exception->getMessage()
            ], 400);
        }

    }
}
