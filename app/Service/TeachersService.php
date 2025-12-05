<?php

namespace App\Service;

use App\Repositories\TeacherRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PHPUnit\Framework\EmptyStringException;

class TeachersService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private TeacherRepository $teacherRepository,
        private UserService $userService,
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
        $username = $this->createTeacherUsername($data['name'], $data['birthday']);

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

    private function createTeacherUsername(string $fullname, string $birthday){
        $username = '';

        if(empty($fullname)){
            throw new EmptyStringException('Fullname is a empty string');
        }

        $splittedName = explode(" ", $fullname);
        $splittedBirthday = explode("-", $birthday);

        if(count($splittedName) == 2) {
            $username .= strtolower($splittedName[0][0]) . strtolower($splittedName[1] . $splittedBirthday[0][2] . $splittedBirthday[0][3]);
        }

        if(count($splittedName) == 3) {
            $username .= strtolower($splittedName[0][0]) . strtolower($splittedName[1][0] . strtolower($splittedName[2]) . $splittedBirthday[0][2] . $splittedBirthday[0][3]);
        }

        return $username;
    }

}
