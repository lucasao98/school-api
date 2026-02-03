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
        private TeacherRepository $teacherRepository,
        private UserService $userService,
        public UtilsService $utilsService
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
        $username = $this->utilsService->createUsername($data['name'], $data['birthday']);
        $registrationNumber = $this->utilsService->makeRegistrationNumber();

        $newUser = [
            'username' => $username,
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'teacher',
        ];

        try {
            $userCreated = $this->userService->create($newUser);

            if($userCreated){
                $newTeacher = [
                    'name' => $data['name'],
                    'cpf' => $data['cpf'],
                    'birthday' => $data['birthday'],
                    'background' => $data['background'],
                    'user_id' => $userCreated->id,
                    'registration_number' => $registrationNumber
                ];
            }

            return $this->teacherRepository->create($newTeacher);
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
