<?php

namespace App\Service;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function __construct(
        private UserRepository $userRepository
    )
    {}

    public function signIn(array $data) {
        $user = $this->userRepository->findUserByUsername($data['username']);

        if($user) {
            if(Hash::check($data['password'], $user->password)){
                $token = $user->createToken($user->password);

                return response()->json(['token' => $token->plainTextToken], 200);
            }else{
                return response()->json(['message' => 'Password is wrong'], 400);
            }
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function signUp(array $data){
        return $this->userRepository->create($data);
    }
}
