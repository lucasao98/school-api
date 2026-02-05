<?php

namespace App\Service;

use App\Repositories\StudentRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private StudentRepository $studentRepository,
        public UtilsService $utilsService,
        private UserService $userService
    )
    {}

    public function listStudents($perPage) {
        try {
            if($perPage && $perPage > 0 ){
                return $this->studentRepository->all($perPage);
            }

            return $this->studentRepository->all(10);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function store(array $data){
        $username = $this->utilsService->createUsername($data['name'] . ' ' . $data['surname'], $data['birthday']);
        $studentEnrollment = $this->utilsService->makeRegistrationNumber();

        $newUser = [
            'username' => $username,
            'email' => $data['parent_email'],
            'password' => $data['name'],
            'role' => 'student',
        ];

        try {
            $userCreated = $this->userService->create($newUser);

            if($userCreated){
                $newStudent = [
                    'name' => $data['name'],
                    'surname' => $data['surname'],
                    'birthday' => $data['birthday'],
                    'parent_email' => $data['parent_email'],
                    'user_id' => $userCreated->id,
                    'student_enrollment' => $studentEnrollment
                ];
            }

            return $this->studentRepository->create($newStudent);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

     public function findStudent($teacherId){
        try {
            return $this->studentRepository->findById($teacherId);

        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException($exception->getMessage());
        }
    }

    public function update(int $studentId, array $studentData){
        $student = $this->findStudent($studentId);

        if(!empty($studentData['name'])){
            $student->name = $studentData['name'];
        }

        if(!empty($studentData['surname'])){
            $student->name = $studentData['surname'];
        }

        if(!empty($studentData['birthday'])){
            $student->birthday = $studentData['birthday'];
        }

        if(!empty($studentData['parent_email'])){
            $student->parent_email = $studentData['parent_email'];
        }

        if($student->isDirty()){
            $studentUpdated = $this->studentRepository->updateStudent($studentId, $student);

            return $studentUpdated;
        }

        return $student;
    }

    public function delete($teacherId){
        $teacher = $this->findStudent($teacherId);

        return $this->studentRepository->delete($teacherId);
    }
}
