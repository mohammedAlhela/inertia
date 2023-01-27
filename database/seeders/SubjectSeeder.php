<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $courses = Course::pluck('id')->toArray();
        $departments = Department::pluck('id')->toArray();

        Subject::create([
            'name' => 'Numbers and letters',
            'course_id' => $courses[0],
            'department_id' => $departments[0],
            'subject_type' => 'Core',
            'type' => 'Practical',
        ]);

        Subject::create([ 
            'name' => 'Multiplication table',
            'course_id' => $courses[1],
            'department_id' => $departments[1],
            'subject_type' => 'Core',
            'type' => 'Theory',
        ]);

        Subject::create([
            'name' => 'Swimming',
            'course_id' => $courses[2],
            'department_id' => $departments[1],
            'subject_type' => 'Elective',
            'type' => 'Practical',
            'students_limit' => 20
        ]);

    }
}
