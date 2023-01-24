<?php

namespace Database\Seeders;

use App\Models\AcademicTerm;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicTermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $academicYear = AcademicTerm::create([
            'academic_year_id' => 3,
            'name' => 'trimester 1',
            'start_date' => '2023-11-21',
            'end_date' => '2024-02-21'
        ]);


        $academicYear = AcademicTerm::create([
            'academic_year_id' => 3,
            'name' => 'trimester 2',
            'start_date' => '2024-03-22',
            'end_date' => '2024-06-22'
        ]);


        $academicYear = AcademicTerm::create([
            'academic_year_id' => 3,
            'name' => 'trimester 3',
            'start_date' => '2024-07-23',
            'end_date' => '2024-10-20'
        ]);
    }
}
