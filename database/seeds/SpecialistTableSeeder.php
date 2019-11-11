<?php

use Illuminate\Database\Seeder;

use App\Models\Specialist\Specialist;

class SpecialistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Specialist::create(['name' => 'Addiction Medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Anaesthesia','domain_id'=>2]);
        Specialist::create(['name' => 'Cardiology','domain_id'=>2]);
        Specialist::create(['name' => 'Clinical genetics','domain_id'=>2]);
        Specialist::create(['name' => 'Clinical pharmacology','domain_id'=>2]);
        Specialist::create(['name' => 'Dermatology','domain_id'=>2]);
        Specialist::create(['name' => 'Emergency medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Endocrinology','domain_id'=>2]);
        Specialist::create(['name' => 'Gastroenterology','domain_id'=>2]);
        Specialist::create(['name' => 'General Medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Geriatrics','domain_id'=>2]);
        Specialist::create(['name' => 'Haematology','domain_id'=>2]);
        Specialist::create(['name' => 'Immunology','domain_id'=>2]);
        Specialist::create(['name' => 'Infectious diseases','domain_id'=>2]);
        Specialist::create(['name' => 'Intensive Care','domain_id'=>2]);
        Specialist::create(['name' => 'Medical administration','domain_id'=>2]);
        Specialist::create(['name' => 'Nephrology','domain_id'=>2]);
        Specialist::create(['name' => 'Nuclear medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Obstetrics and gynaecology','domain_id'=>2]);
        Specialist::create(['name' => 'Occupational and environmental medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Oncology','domain_id'=>2]);
        Specialist::create(['name' => 'Ophthalmology','domain_id'=>2]);
        Specialist::create(['name' => 'Otolaryngology','domain_id'=>2]);
        Specialist::create(['name' => 'Paediatrics','domain_id'=>2]);
        Specialist::create(['name' => 'Pain medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Palliative care medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Pathology','domain_id'=>2]);
        Specialist::create(['name' => 'Plastic Surgery','domain_id'=>2]);
        Specialist::create(['name' => 'Psychiatry','domain_id'=>2]);
        Specialist::create(['name' => 'Public Health','domain_id'=>2]);
        Specialist::create(['name' => 'Radiology','domain_id'=>2]);
        Specialist::create(['name' => 'Rehabilitation medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Respiratory and sleep medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Rheumatology','domain_id'=>2]);
        Specialist::create(['name' => 'Sexual health medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Sport medicine','domain_id'=>2]);
        Specialist::create(['name' => 'Surgery','domain_id'=>2]);
        Specialist::create(['name' => 'Urology','domain_id'=>2]);
        Specialist::create(['name' => 'Other Speciality','domain_id'=>2]);

        Specialist::create(['name' => 'Breast Feeding','domain_id'=>3]);
        Specialist::create(['name' => 'Counselling','domain_id'=>3]);
        Specialist::create(['name' => 'Chiropractor','domain_id'=>3]);
        Specialist::create(['name' => 'Dental practitioner','domain_id'=>3]);
        Specialist::create(['name' => 'Dietitians','domain_id'=>3]);
        Specialist::create(['name' => 'Exercise physiologist','domain_id'=>3]);
        Specialist::create(['name' => 'First Aid','domain_id'=>3]);
        Specialist::create(['name' => 'Infant care advice','domain_id'=>3]);
        Specialist::create(['name' => 'Nurse practitioner','domain_id'=>3]);
        Specialist::create(['name' => 'Nutritionist','domain_id'=>3]);
        Specialist::create(['name' => 'Osteopath','domain_id'=>3]);
        Specialist::create(['name' => 'Pathology tests advice','domain_id'=>3]);
        Specialist::create(['name' => 'Physiotherapist','domain_id'=>3]);
        Specialist::create(['name' => 'Psychologist','domain_id'=>3]);
        Specialist::create(['name' => 'Radiology tests advice','domain_id'=>3]);
        Specialist::create(['name' => 'Social Worker','domain_id'=>3]);
        Specialist::create(['name' => 'Trainers','domain_id'=>3]);
        Specialist::create(['name' => 'Other Allied Health','domain_id'=>3]);

        Specialist::create(['name' => 'General Practice','domain_id'=>1]);

    }
}
