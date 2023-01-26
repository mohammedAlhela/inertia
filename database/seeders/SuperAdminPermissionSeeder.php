<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $permissionsIds = Permission::pluck('id')->all();

        $users = User::where('role' , 'super-admin')->get();

        foreach ($users as $user) { 
            $user->permissions()->sync($permissionsIds);
        }


    


    }
}
