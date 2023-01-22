<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = User::where('role' , 'admin')->get();

        foreach ($users as $key => $user) {
            Admin::factory(1)->create(['user_id' => $user->id]);
        }

    }
}
