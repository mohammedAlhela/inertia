<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'mohammed alhelal',
            'name' => 'mohammed alhelal',
            'email' => 'mohamdalhelal7@gmail.com',
            'password' => Hash::make('Mohammed!@#123'),
            'mobile' => '0504934593',
            'email_verified_at' => now(),
            'role' => 'super-admin'
        ]);

    }
}
