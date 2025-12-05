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

            switch ($user->role) {
                case 'admin':
                    $token = $user->createToken($user->password, ['admin']);
                    break;
                case 'principal':
                    $token = $user->createToken($user->password, ['principal']);
                    break;
                case 'teacher':
                    $token = $user->createToken($user->password, ['teacher']);
                    break;
                case 'student':
                    $token = $user->createToken($user->password, ['student']);
                    break;
            }

            return $token->plainTextToken;
        }

        throw new Exception('User not found');
    }
}
