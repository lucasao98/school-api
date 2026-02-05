<?php

namespace App\Repositories;

use App\Models\Student;
use App\Repositories\Interfaces\StudentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    protected Model $model;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->model = new Student();
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

    public function updateStudent(int $studentId, Student $student){
        $student->save();

        return $student;
    }

    public function delete($id){
        return $this->model->delete($id);
    }
}
