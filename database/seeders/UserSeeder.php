<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;

use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('users')->insert([
            'name' => 'mohammed alhelal',
            'email' => 'mohamdalhelal7@gmail.com',
            'password' => Hash::make('Mohammed!@#123'),
            'status' => 1,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'amer alhelal',
            'email' => 'amer@gmail.com',
            'password' => Hash::make('Amer!@#123'),
            'status' => 1,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'alaa alhelal',
            'email' => 'alaa@gmail.com',
            'password' => Hash::make('Alaa!@#123'),
            'status' => 1,
            'email_verified_at' => now()
        ]);


    }
}
