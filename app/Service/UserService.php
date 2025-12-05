<?php

namespace App\Service;

use App\Repositories\UserRepository;
use Exception;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ){}

    public function create(array $data){
        try {
            $createdUser = $this->userRepository->create($data);

            return $createdUser;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

}
