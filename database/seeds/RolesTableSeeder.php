<?php

use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\Practice\PracticeRole;
use App\Models\Hospital\Hospital;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add Roles
         *
         */

        // Role::create([
        //     'name'        => 'Receptionist',
        //     'slug'        => 'receptionist',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);
        // Role::create([
        //     'name'        => 'Salesman',
        //     'slug'        => 'salesman',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);
        // Role::create([
        //     'name'        => 'Head of Doctor',
        //     'slug'        => 'head.doctor',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);
        // Role::create([
        //     'name'        => 'Admin',
        //     'slug'        => 'admin',
        //     'description' => 'HR',
        //     'level'       => 5,
        // ]);
        // Role::create([
        //     'name'        => 'User',
        //     'slug'        => 'user',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);
        // Role::create([
        //     'name'        => 'Accountant',
        //     'slug'        => 'accountant',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);
        // Role::create([
        //     'name'        => 'Laboratorist',
        //     'slug'        => 'laboratorist',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);
        // Role::create([
        //     'name'        => 'Nurse',
        //     'slug'        => 'nurse',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);
        // Role::create([
        //     'name'        => 'Pharmacist',
        //     'slug'        => 'pharmacist',
        //     'description' => 'HR',
        //     'level'       => 1,
        // ]);

        Role::create([
            'name'        => 'Pharmacy',
            'slug'        => 'pharmacy',
            'description' => 'Pharmacy',
            'level'       => 1,
        ]);
        Role::create([
            'name'        => 'Hospital',
            'slug'        => 'hospital',
            'description' => 'Hospital',
            'level'       => 1,
        ]);
        Role::create([
            'name'        => 'Supplier',
            'slug'        => 'supplier',
            'description' => 'Supplier',
            'level'       => 1,
        ]);
        Role::create([
            'name'        => 'System Admin',
            'slug'        => 'system.admin',
            'description' => 'Manage the entire system',
            'level'       => 5,
        ]);
        Role::create([
            'name'        => 'Patient',
            'slug'        => 'patient',
            'description' => 'Patient',
            'level'       => 1,
        ]);
        Role::create([
            'name'        => 'Doctor',
            'slug'        => 'doctor',
            'description' => 'Doctor',
            'level'       => 1,
        ]);
        Role::create([
            'name'        => 'Manufacturer',
            'slug'        => 'manufacturer',
            'description' => 'Manufacturer',
            'level'       => 1,
        ]);
        Role::create([
            'name'        => 'Wholesaler',
            'slug'        => 'wholesaler',
            'description' => 'Wholesaler',
            'level'       => 1,
        ]);
        // Role::create([
        //     'name'        => 'Master admin',
        //     'slug'        => 'master.admin',
        //     'description' => 'Manage everything at organization level',
        //     'level'       => 5,
        // ]);

        // $hospital = Hospital::find(1);
        // $practice = $hospital->practices()->where('category','Main')->get()->first();
        // PracticeRole::create([
        //     'practice_id' => $practice->id,
        //     'slug' => 'master.admin',
        //     'name' => 'Master admin',
        //     'description' => 'System Adminstrator',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => $practice->id,
        //     'slug' => 'general.manager',
        //     'name' => 'General Manager',
        //     'description' => 'Main Branch Manager. Can manage all branches',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => $practice->id,
        //     'slug' => 'branch.manager',
        //     'name' => 'Branch Manager',
        //     'description' => 'Sub branch Manager. Manages all activities at branch level',
        // ]);

        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'accountant',
        //     'name' => 'Accountant',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'doctor',
        //     'name' => 'Doctor',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'receptionist',
        //     'name' => 'Receptionist',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'laboratorist',
        //     'name' => 'Laboratorist',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'nurse',
        //     'name' => 'Nurse',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'pharmacist',
        //     'name' => 'Pharmacist',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'representative',
        //     'name' => 'Representative',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'case.manager',
        //     'name' => 'Case Manager',
        //     'description' => 'Desc',
        // ]);
        // PracticeRole::create([
        //     'practice_id' => 1,
        //     'slug' => 'patient',
        //     'name' => 'Patient',
        //     'description' => 'Desc',
        // ]);

    }
}
