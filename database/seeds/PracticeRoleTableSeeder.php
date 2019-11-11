<?php

use Illuminate\Database\Seeder;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeRole;

class PracticeRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$store = Practice::find(2);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'master.admin',
            'name' => 'Master admin',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'accountant',
            'name' => 'Accountant',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'doctor',
            'name' => 'Doctor',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'receptionist',
            'name' => 'Receptionist',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'laboratorist',
            'name' => 'Laboratorist',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'nurse',
            'name' => 'Nurse',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'pharmacist',
            'name' => 'Pharmacist',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'representative',
            'name' => 'Representative',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'case.manager',
            'name' => 'Case Manager',
            'description' => 'Desc',
        ]);
        PracticeRole::create([
            'practice_id' => 1,
            'slug' => 'patient',
            'name' => 'Patient',
            'description' => 'Desc',
        ]);
    }
}
