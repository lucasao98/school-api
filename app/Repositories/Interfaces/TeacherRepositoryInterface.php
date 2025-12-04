<?php

namespace App\Repositories\Interfaces;

use App\Models\Teacher;

interface TeacherRepositoryInterface
{
   public function updateTeacher(int $teacherId, Teacher $data);
}
