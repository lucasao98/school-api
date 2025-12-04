<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{

    protected Model $model;

    abstract protected function all($perPage);

    abstract protected function findById(int $id);

    abstract protected function delete(int $id);

    abstract protected function create(array $data);
}
