<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('companies')->insert([
            'name' => 'Sahara school',
            'email' => 'Sahara@gmail.company',
            'mobile' => '0504934593',
            'image' => '/images/main/company.webp',

        ]);

    }
}
