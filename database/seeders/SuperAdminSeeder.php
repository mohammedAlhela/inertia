<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'email' => 'mohamdalhelal7@gmail.com',
            'password' => Hash::make('Mohammed!@#123'),
            'temp_credentials' => false,
            'role' => 'super-admin',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'username' => 'mohammed123',
            'first_name' => 'mohammed',
            'last_name' => 'alhelal',
            'phone' => '0696979697',
        ]);

    }
}
