<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(){
        $this->model = new User();
    }

    public function all(){
        try {
            return $this->model->paginate(10);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to get users'], 400);
        }
    }

    public function create($data){
        try {
            return $this->model->create($data);
        } catch (QueryException $exception) {
            return response()->json(['message' => 'Failed to create user'], 409);
        }
    }

    public function findUserByUsername($username){
        try {
            return $this->model->where('username', $username)->first();
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'User not found'], 400);
        }
    }

    public function findById($id){
        try {
            return $this->model->find($id);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'User not found'], 400);
        }
    }

    public function delete($id){
        try {
            $user = $this->model->find($id);

            if($user){
                $user->delete();
            }
            return response()->json(204);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => 'User not found'], 400);
        }
    }
}
