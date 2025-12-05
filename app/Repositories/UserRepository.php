<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected Model $model;

    public function __construct(){
        $this->model = new User();
    }

    public function all($perPage){
        return $this->model->paginate($perPage);
    }

     public function create($data){
        return $this->model->create($data);
    }

    public function findById($id){
        return $this->model->findOrFail($id);
    }

    public function findUserByUsername($username){
        return $this->model->where('username', $username)->first();
    }

   public function delete($id){
        return $this->model->delete($id);
    }
}
