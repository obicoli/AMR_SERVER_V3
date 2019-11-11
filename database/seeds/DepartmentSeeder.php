<?php

use Illuminate\Database\Seeder;
use \App\Models\Practice\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(['name' => 'Procurement','practice_id'=>2]);
        Department::create(['name' => 'Finance','practice_id'=>2]);
        Department::create(['name' => 'Accident and emergency (A&E)','practice_id'=>2, 'description'=>'This department (sometimes called Casualty) is where you\'re likely to be taken if you\'ve called an ambulance in an emergency']);
        Department::create(['name' => 'Anaesthetics','practice_id'=>2,'description'=>'Doctors in this department give anaesthetic for operations.']);
        Department::create(['name' => 'Breast screening','practice_id'=>2,'description'=>'This unit screens women for breast cancer, either through routine mammogram examinations or at the request of doctors. It\'s usually linked to an X-ray department.']);
        Department::create(['name' => 'Cardiology','practice_id'=>2,'description'=>'This department provides medical care to patients who have problems with their heart or circulation. It treats people on an inpatient and outpatient basis.']);
        Department::create(['name' => 'Chaplaincy','practice_id'=>2,'description'=>'Chaplains promote the spiritual and pastoral wellbeing of patients, relatives and staff.']);
        Department::create(['name' => 'Critical care','practice_id'=>2,'description'=>'Sometimes called intensive care, this unit is for the most seriously ill patients.']);
        Department::create(['name' => 'Diagnostic imaging','practice_id'=>2,'description'=>'Formerly known as X-ray, this department provides a full range of diagnostic imaging services including:']);
        Department::create(['name' => 'Discharge lounge','practice_id'=>2,'description'=>'Many hospitals now have discharge lounges to help your final day in hospital go smoothly.']);
        Department::create(['name' => 'Ear nose and throat (ENT)','practice_id'=>2,'description'=>'The ENT department provides care for patients with a variety of problems']);
        Department::create(['name' => 'Elderly services department','practice_id'=>2,'description'=>'Led by consultant physicians specialising in geriatric medicine, this department looks after a wide range of problems associated with the elderly']);
        Department::create(['name' => 'Gastroenterology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'General surgery','practice_id'=>2,'description'=>'The general surgery ward covers a wide range of surgery']);
        Department::create(['name' => 'Gynaecology','practice_id'=>2,'description'=>'These departments investigate and treat problems of the female urinary tract and reproductive organs, such as endometritis, infertility and incontinence.']);
        Department::create(['name' => 'Haematology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Maternity departments','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Microbiology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Neonatal unit','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Nephrology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Neurology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Nutrition and dietetics','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Obstetrics and gynaecology units','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Occupational therapy','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Oncology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Ophthalmology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Orthopaedics','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Pain management clinics','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Pharmacy','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Physiotherapy','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Radiotherapy','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Renal unit','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Rheumatology','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Sexual health (genitourinary medicine)','practice_id'=>2,'description'=>'']);
        Department::create(['name' => 'Urology','practice_id'=>2,'description'=>'']);
    }
}
