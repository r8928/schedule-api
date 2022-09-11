<?php

namespace Database\Seeders;

use App\Enums\ClassType;
use App\Enums\SubjectType;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Schema::disableForeignKeyConstraints();

        DB::table('teachers')->truncate();
        DB::table('teacher_classes')->truncate();
        DB::table('teacher_subjects')->truncate();

        Schema::enableForeignKeyConstraints();

        for ($i = 0; $i < 3; $i++) {
            $teacher_id = DB::table('teachers')->insertGetId([
                'name' => $faker->firstName() . ' ' . $faker->lastName(),
                'qualifications' => $faker->words(3, true)
            ]);

            $classes = collect(ClassType::getKeys())->random(3);
            $subjects = collect(SubjectType::getKeys())->random(3);

            for ($j = 0; $j < 3; $j++) {
                DB::table('teacher_classes')->insert(['teacher_id' => $teacher_id, 'class' => $classes[$j]]);
                DB::table('teacher_subjects')->insert(['teacher_id' => $teacher_id, 'subject' => $subjects[$j]]);
            }
        }
    }
}
