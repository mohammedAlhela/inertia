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
            'username' => 'mohammed123',
            'password' => Hash::make('Mohammed!@#123'),
            'temp_credentials' => false,
            'role' => 'super-admin',
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'email' => 'mohamdalhelal7@gmail.com',
            'name' => 'mohammed alhelal',
            'phone' => '0696979697',
        ]);

    }
}
