<?php

use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class ConnectRelationshipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Get Available Permissions.
         */
        $permissions = Permission::all();
        /**
         * Attach Permissions to Roles.
         */
        //$roleAdmin = Role::where('slug', '=', 'admin')->first();
        //$roleDoctor = Role::where('slug', '=', 'doctor')->first();
        $adminDoctor = Role::where('slug', '=', 'system.admin')->first();
        $masterAdmin = Role::where('slug', '=', 'master.admin')->first();
        //$rolePractice = Role::where('slug', '=', 'practice')->first();
        // foreach ($permissions as $permission) {
        //     $adminDoctor->attachPermission($permission);
        //     $masterAdmin->attachPermission($permission);
        // }

    }
}
