<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Section;

use App\Models\Course;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $courses = Course::pluck('id')->toArray();

        Section::create([
            'name' => 'Section 1',
            'course_id' => $courses[0],
            'students_limit' => 60,
        ]);

        Section::create([
            'name' => 'Section 2',
            'course_id' => $courses[1],
            'students_limit' => 70,
        ]);

        Section::create([
            'name' => 'Section 3',
            'course_id' => $courses[2],
            'students_limit' => 80,
        ]);

    }
}
