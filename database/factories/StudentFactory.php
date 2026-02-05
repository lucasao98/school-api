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
    protected $utilsService;

     public function __construct()
    {
        parent::__construct();
        $this->utilsService = app(UtilsService::class);
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     public function definition(): array
    {
         // Primeiro, criar o User
        $user = User::factory()->create([
            'role' => 'student',
        ]);

        // Gerar nome e sobrenome para o student
        $name = fake()->firstName();
        $surname = fake()->lastName();
        $birthday = fake()->date('Y-m-d');

        // Atualizar o username do user com base nos dados do student
        $user->update([
            'username' => app(UtilsService::class)->createUsername(
                $name . ' ' . $surname,
                $birthday
            ),
        ]);

        return [
            'name' => $name,
            'surname' => $surname,
            'parent_email' => fake()->unique()->safeEmail(),
            'birthday' => $birthday,
            'student_enrollment' => app(UtilsService::class)->makeRegistrationNumber(),
            'user_id' => $user->id,
        ];
    }

     /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Student $student) {
            // Criar usuário associado APÓS a criação do estudante
            $user = User::factory()->create([
                'username' => app(UtilsService::class)->createUsername(
                    $student->name . ' ' . $student->surname,
                    $student->birthday
                ),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => Hash::make('1234'),
                'remember_token' => Str::random(10),
                'role' => 'student',
            ]);

            $student->user_id = $user->id;
            $student->save();
        });
    }
}
