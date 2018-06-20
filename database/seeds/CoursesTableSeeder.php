<?php

use App\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::create([
            'code' => 'bt',
            'description' => 'basic training',
            'added_by' => 1
        ]);

        Course::create([
            'code' => 'ssatsdsd',
            'description' => 'ship security awareness training and seafarer with designated security duties',
            'added_by' => 1
        ]);

        Course::create([
            'code' => 'pscrb',
            'description' => 'proficiency in survival craft and rescue boats',
            'added_by' => 1
        ]);

        Course::create([
            'code' => 'pfrb',
            'description' => 'proficiency in fast rescue boats',
            'added_by' => 1
        ]);

        Course::create([
            'code' => 'fflb',
            'description' => 'free fall lifeboat',
            'added_by' => 1
        ]);
    }
}
