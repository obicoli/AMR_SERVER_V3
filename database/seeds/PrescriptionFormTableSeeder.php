<?php

use Illuminate\Database\Seeder;
use App\Models\Emr\Prescription\PrescriptionForm;

class PrescriptionFormTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presc = PrescriptionForm::create(['name' => 'Tablet']);
        $presc = PrescriptionForm::create(['name' => 'Syrup']);
        $presc = PrescriptionForm::create(['name' => 'Suspension']);
        $presc = PrescriptionForm::create(['name' => 'Powder']);
        $presc = PrescriptionForm::create(['name' => 'Cream']);
        $presc = PrescriptionForm::create(['name' => 'Ointment']);
        $presc = PrescriptionForm::create(['name' => 'Lotion']);
    }
}
