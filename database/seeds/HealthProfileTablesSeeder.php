<?php

use Illuminate\Database\Seeder;
use \App\Models\Emr\Health\Surgery;
use \App\Models\Emr\Health\Allergies;
use \App\Models\Emr\Health\Medication;
use \App\Models\Emr\Health\HealthCondition;

class HealthProfileTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Surgeries
        Surgery::create(['name' => 'Plastic Surgery']);
        //Allergies
        Allergies::create(['name' => 'D-Penamine']);
        Allergies::create(['name' => 'Cope']);
        Allergies::create(['name' => 'Dipentum']);
        Allergies::create(['name' => 'doripenem']);
        Allergies::create(['name' => 'AtroPen']);
        Allergies::create(['name' => 'Beepen VK']);
        Allergies::create(['name' => 'isothipendyl']);
        Allergies::create(['name' => 'Lipopen Absorptn Enhance Base']);
        Allergies::create(['name' => 'EpiPen']);
        Allergies::create(['name' => 'meropenem']);
        Allergies::create(['name' => 'penimepicycline']);
        Allergies::create(['name' => 'Penlen']);
        Allergies::create(['name' => 'PenSomal']);
        Allergies::create(['name' => 'Permapen']);
        Allergies::create(['name' => 'penicillin G procaine']);
        Allergies::create(['name' => 'Penlac']);
        Allergies::create(['name' => 'Penthrane']);
        Allergies::create(['name' => 'pentifylline']);
        Allergies::create(['name' => 'cyclopenthiazide']);
        Allergies::create(['name' => 'cyclopentolate']);
        Allergies::create(['name' => 'icosapent ethyl']);
        //Medications
        Medication::create(['name' => 'C1 esterase inhibitor 3,000 unit subcutaneous solution']);
        Medication::create(['name' => 'Fibryga 1 gram (700 mg-1,300 mg) intravenous solution']);
        Medication::create(['name' => 'FreeStyle Libre 10 Day Sensor kit']);
        Medication::create(['name' => 'Hemlibra 60 mg/0.4 mL subcutaneous solution']);
        Medication::create(['name' => 'bortezomib 3.5 mg intravenous solution']);
        Medication::create(['name' => 'glasdegib 25 mg tablet']);
        Medication::create(['name' => 'ibrutinib 70 mg capsule']);
        Medication::create(['name' => 'ivosidenib 250 mg tablet']);
        Medication::create(['name' => 'riboflav 0.146% eye drops-riboflav 0.146% in 20% dextran visc eye drop']);
        Medication::create(['name' => 'thrombin(human)-fibrinogen-aprotinin syn-calcium 10 mL topical syringe']);
        //Conditions
        HealthCondition::create(['name'=>'Diarrhea']);
        HealthCondition::create(['name'=>'Laboratory or Diagnostic Testing Question']);
        HealthCondition::create(['name'=>'Diabetes mellitus']);
        HealthCondition::create(['name'=>'Myocardial Infarction']);
        HealthCondition::create(['name'=>'Barotitis Media']);
        HealthCondition::create(['name'=>'Diabetic Gastroparesis']);
        HealthCondition::create(['name'=>'Epicondylitis - Medial (Golfer\'s Elbow)']);
        HealthCondition::create(['name'=>'Campylobacter Diarrhea']);
        HealthCondition::create(['name'=>'Traveler\'s Diarrhea']);
        HealthCondition::create(['name'=>'Radiation Proctitis']);
        HealthCondition::create(['name'=>'Tachycardia (Fast Heart Beat)']);
        HealthCondition::create(['name'=>'Slow Heart Beat (Bradycardia)']);
        HealthCondition::create(['name'=>'Ventricular Tachycardia']);
        HealthCondition::create(['name'=>'Diabetic Retinopathy']);
        HealthCondition::create(['name'=>'Diabetic Foot Ulcer']);
        HealthCondition::create(['name'=>'Urethritis - Chlamydia Trachomatis']);
        HealthCondition::create(['name'=>'Postprandial Hypotension']);
        HealthCondition::create(['name'=>'Postural Orthostatic Tachycardia Syndrome']);
        HealthCondition::create(['name'=>'Cardiac Ischemia']);
        HealthCondition::create(['name'=>'Otitis Media - Acute']);
    }
}
