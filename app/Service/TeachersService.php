<?php

namespace App\Service;

use App\Repositories\TeacherRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeachersService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private TeacherRepository $teacherRepository
    )
    {}

    public function listTeachers($perPage) {
        try {
            if($perPage && $perPage > 0 ){
                return $this->teacherRepository->all($perPage);
            }

            return $this->teacherRepository->all(10);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function store(array $data){
        try {
            return $this->teacherRepository->create($data);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function findTeacher($teacherId){
        try {
            return $this->teacherRepository->findById($teacherId);

        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function delete($teacherId){
        $teacher = $this->findTeacher($teacherId);

        return $this->teacherRepository->delete($teacherId);
    }

    public function update(int $teacherId, array $teacherData){
        $teacher = $this->findTeacher($teacherId);

        if(!empty($teacherData['name'])){
            $teacher->name = $teacherData['name'];
        }

        if(!empty($teacherData['cpf'])){
            $teacher->cpf = $teacherData['cpf'];
        }

        if(!empty($teacherData['birthday'])){
            $teacher->birthday = $teacherData['birthday'];
        }

        if(!empty($teacherData['background'])){
            $teacher->background = $teacherData['background'];
        }

        if($teacher->isDirty()){
            $teacherUpdated = $this->teacherRepository->updateTeacher($teacherId, $teacher);

            return $teacherUpdated;
        }



        return $teacher;
    }

}
