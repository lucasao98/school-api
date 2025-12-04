<?php

namespace App\Repositories;

use App\Models\Teacher;
use App\Repositories\Interfaces\TeacherRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TeacherRepository extends BaseRepository implements TeacherRepositoryInterface
{
    protected Model $model;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->model = new Teacher();
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

    public function updateTeacher(int $teacherId, Teacher $teacher){
        $teacher->save();

        return $teacher;
    }

    public function delete($id){
        return $this->model->delete($id);
    }
}
