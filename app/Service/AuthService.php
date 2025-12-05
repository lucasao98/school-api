<?php

namespace App\Service;

use App\Repositories\UserRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function __construct(
        private UserRepository $userRepository
    )
    {}

    public function signIn(array $data) {
        $user = $this->userRepository->findUserByUsername($data['username']);

        if(!$user){
            throw new ModelNotFoundException('Username not found');
        }

        if($user) {
            if(!Hash::check($data['password'], $user->password)){
                throw new Exception('Password is wrong');
            }

            $token = $user->createToken($user->password);

            return $token->plainTextToken;
        }

        throw new Exception('User not found');
    }

    public function signUp(array $data){
        try {

            return $this->userRepository->create($data);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
