<?php

namespace App\Repositories\Interfaces;

use App\Models\Student;

interface StudentRepositoryInterface
{
   public function updateStudent(int $studentId, Student $data);
}
