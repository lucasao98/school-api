<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\User;
use App\Service\UtilsService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'surname' => fake()->lastName(),
            'parent_email' => fake()->unique()->safeEmail(),
            'birthday' => fake()->date('Y-m-d'),
            'user_id' => User::factory()->create([
                'username' => fake()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('1234'),
                'remember_token' => Str::random(10),
                'role' => 'student',
            ]),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Student $student) {
            $utilsService = new UtilsService();
            $student->student_enrollment = $utilsService->makeRegistrationNumber();
        });
    }
}
