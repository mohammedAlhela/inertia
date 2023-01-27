<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $departments = Department::pluck('id')->toArray();
        $coursesNames = array('Kindergarten', 'Grade 1', 'Grade 2', 'Grade 3');

        Course::create([
            'name' => $coursesNames[0],
            'department_id' => $departments[0],
            'students_limit' => 600,
            'evaluation_type' => 'Normal',
        ]);

        Course::create([
            'name' => $coursesNames[1],
            'department_id' => $departments[1],
            'students_limit' => 1000,
            'evaluation_type' => 'GPA',
        ]);

        Course::create([
            'name' => $coursesNames[2],
            'department_id' => $departments[1],
            'students_limit' => 1000,
            'evaluation_type' => 'GPA',
        ]);

        Course::create([
            'name' => $coursesNames[3],
            'department_id' => $departments[1],
            'students_limit' => 1000,
            'evaluation_type' => 'GPA',
        ]);

    }
}
