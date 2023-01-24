<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $academicYear = AcademicYear::create([
            'name' => '2021-2022',
            'start_date' => '2021-11-20', 
            'end_date' => '2022-10-20',
        ]);


        $academicYear = AcademicYear::create([
            'name' => '2022-2023',
            'start_date' => '2022-11-20', 
            'end_date' => '2023-10-20',
        ]);


        $academicYear = AcademicYear::create([
            'name' => '2023-2024',
            'start_date' => '2023-11-20', 
            'end_date' => '2024-10-20',
        ]);
    }
}
