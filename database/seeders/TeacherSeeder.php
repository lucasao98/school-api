<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $int= rand(1262055681,1262055681);
        $int= mt_rand(1262055681,1262055681);
        $random_date = date("Y-m-d", $int);

        DB::table('teachers')->insert([
            'name' => fake()->name(),
            'cpf' => strval(rand(1262055681,1262055681)),
            'background' => 'Licenciatura em Biologia',
            'birthday' => $random_date,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
