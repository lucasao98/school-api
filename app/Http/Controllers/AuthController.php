<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function signIn(LoginRequest $loginRequest){
        $validated_input = $loginRequest->validated();

        return $this->authService->signIn($validated_input);
    }

    public function signUp(SignUpRequest $signUpRequest){
        $validated_signup = $signUpRequest->validated();

        return $this->authService->signUp($validated_signup);
    }
}
