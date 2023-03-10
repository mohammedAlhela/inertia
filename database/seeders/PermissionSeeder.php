<?php

namespace Database\Seeders;

use DB;
use Helper;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        DB::table('permissions')->truncate();
        DB::table('permission_user')->truncate();
        foreach (Helper::getPermissions() as $permission) {

            DB::table('permissions')->insert([
                'name' => $permission,
            ]);
        }

    }
}
