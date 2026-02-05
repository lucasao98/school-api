<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Service\StudentService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $studentService
    )
    {}
    public function all(Request $request) {
        $perPage = $request->query('perPage');
        try {
            $listStudents = $this->studentService->listStudents($perPage);

            return response()->json($listStudents, 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Not Found',
                'status' => 404,
                'detail' => $exception->getMessage()
            ]);
        }
    }

    public function store(StudentStoreRequest $studentRequest){
        $data_validated = $studentRequest->validated();

        try {
            $student = $this->studentService->store($data_validated);

            if($student) {
                return response()->json(new StudentResource($student), 201);
            }
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Error',
                'status' => 400,
                'detail' => $exception->getMessage()
            ], 400);
        }
    }


    public function find(int $studentId){
        try {
            $student = $this->studentService->findStudent($studentId);

            return response()->json(new StudentResource($student), 200);
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Not Found',
                'status' => 404,
                'detail' => $exception->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(int $studentId, StudentUpdateRequest $studentRequest){
        $data_validated = $studentRequest->validated();

        try {
            $student = $this->studentService->update($studentId, $data_validated);

            return response()->json(new StudentResource(($student)), 200);

        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Error',
                'status' => 400,
                'detail' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $studentId)
    {
        try {
            $this->studentService->delete($studentId);

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
