<?php

namespace Database\Seeders;

use App\Models\AcademicTerm;
use App\Models\AcademicYear;
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


        $academicYear = AcademicYear::where('name' , '2023-2024')->first();

        $academicYear = AcademicTerm::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'trimester 1',
            'start_date' => '2023-11-21',
            'end_date' => '2024-02-21'
        ]);


        $academicYear = AcademicTerm::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'trimester 2',
            'start_date' => '2024-03-22',
            'end_date' => '2024-06-22'
        ]);


        $academicYear = AcademicTerm::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'trimester 3',
            'start_date' => '2024-07-23',
            'end_date' => '2024-10-20'
        ]);
    }
}
