<?php

use Illuminate\Database\Seeder;
use App\Models\Consultation\Prescription\DoctorAction;

class ConsultDoctorActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = DoctorAction::create(['name' => 'Advised Self Care']);
        $actions = DoctorAction::create(['name' => 'Gave Prescription']);
        $actions = DoctorAction::create(['name' => 'Referred to Physical GP']);
        $actions = DoctorAction::create(['name' => 'Referred to Consultant']);
        $actions = DoctorAction::create(['name' => 'Ordered Lab or Image Test']);
    }
}
