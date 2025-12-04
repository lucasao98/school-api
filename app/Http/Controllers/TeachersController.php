<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Http\Resources\TeacherResource;
use App\Service\TeachersService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TeachersController extends Controller
{
    public function __construct(
        protected TeachersService $teacherService
    ){}
    public function all(Request $request) {
        $perPage = $request->query('perPage');
        try {
            $listTeachers = $this->teacherService->listTeachers($perPage);

            return response()->json($listTeachers, 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Not Found',
                'status' => 404,
                'detail' => $exception->getMessage()
            ]);
        }
    }

    public function store(TeacherStoreRequest $teacherRequest){
        $data_validated = $teacherRequest->validated();

        try {
            $teacher = $this->teacherService->store($data_validated);

            if($teacher) {
                return response()->json(new TeacherResource($teacher), 201);
            }
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Error',
                'status' => 400,
                'detail' => $exception->getMessage()
            ], 400);
        }
    }

    public function find(int $teacherId){
        try {
            $teacher = $this->teacherService->findTeacher($teacherId);

            return response()->json(new TeacherResource($teacher), 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Not Found',
                'status' => 404,
                'detail' => $exception->getMessage()
            ], 404);
        }
    }

    public function update(int $teacherId, TeacherUpdateRequest $teacherRequest){
        $data_validated = $teacherRequest->validated();

        try {
            $teacher = $this->teacherService->update($teacherId, $data_validated);

            return response()->json(new TeacherResource(($teacher)), 200);

        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Error',
                'status' => 400,
                'detail' => $exception->getMessage()
            ], 400);
        }
    }

    public function destroy(int $teacherId){
        try {
            $this->teacherService->delete($teacherId);

            return response()->json([], 204);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'message' => 'Not Found',
                'status' => 404,
                'detail' => $exception->getMessage()
            ], 404);
        }
    }
}
