<?php

use Illuminate\Database\Seeder;

use App\Models\Symptom\Symptom;

class SymptomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //$category = SymptomCategory::create(['name' => 'General Symptoms']);
        $symptom = Symptom::create(['name' => 'Fever','category_id' => 1]);
        $symptom = Symptom::create(['name' => 'Weight Change','category_id' => 1]);
        $symptom = Symptom::create(['name' => 'Difficulty Sleeping','category_id' => 1]);
        $symptom = Symptom::create(['name' => 'Loss of Appetite','category_id' => 1]);
        $symptom = Symptom::create(['name' => 'Mood Changes','category_id' => 1]);
        $symptom = Symptom::create(['name' => 'Fatigue or Weakness','category_id' => 1]);
        $symptom = Symptom::create(['name' => 'Foreign Travel (Past Month)','category_id' => 1]);
        $symptom = Symptom::create(['name' => 'Hospitalized (Past Six Months)','category_id' => 1]);

        $symptom = Symptom::create(['name' => 'Chest Pressure or Pain','category_id' => 2]);
        $symptom = Symptom::create(['name' => 'Palpitations','category_id' => 2]);
        $symptom = Symptom::create(['name' => 'Cough','category_id' => 2]);
        $symptom = Symptom::create(['name' => 'Sputum','category_id' => 2]);
        $symptom = Symptom::create(['name' => 'Shortness of Breath','category_id' => 2]);
        $symptom = Symptom::create(['name' => 'Decreased Exercise Tolerance','category_id' => 2]);
        $symptom = Symptom::create(['name' => 'History of Smoking','category_id' => 2]);

        $symptom = Symptom::create(['name' => 'Sore Throat','category_id' => 3]);
        $symptom = Symptom::create(['name' => 'Nausea or Vomiting','category_id' => 3]);
        $symptom = Symptom::create(['name' => 'Difficulty or Pain Swallowing','category_id' => 3]);
        $symptom = Symptom::create(['name' => 'Heartburn or Reflux','category_id' => 3]);
        $symptom = Symptom::create(['name' => 'Diarrhea','category_id' => 3]);
        $symptom = Symptom::create(['name' => 'Constipation','category_id' => 3]);
        $symptom = Symptom::create(['name' => 'Abdominal pain or discomfort','category_id' => 3]);

        $symptom = Symptom::create(['name' => 'Cancer','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Diabetes','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Heart Disease (CHF, MI)','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Stroke','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'High Blood Pressure','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'High Cholesterol','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Asthma or COPD','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Depression','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Arthritis','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Abnormal Thyroid','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Pregnant','category_id' => 4]);
        $symptom = Symptom::create(['name' => 'Other','category_id' => 4]);

        $symptom = Symptom::create(['name' => 'Headache','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Dizzy or Lightheaded','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Vision Changes','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Hearing Loss or Ringing','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Ear Drainage','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Nasal Discharge','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Congestion or Sinus Problem','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Allergies','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Numbness or Tingling','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'History of Fainting or Seizure','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'Memory Loss','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'History of Stroke','category_id' => 5]);
        $symptom = Symptom::create(['name' => 'History of Falls','category_id' => 5]);

        $symptom = Symptom::create(['name' => 'Flank Pain','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'Burning with Urination','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'History of STIs','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'Irregular Periods','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'Vaginal Bleeding','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'Vaginal Discharge','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'Penile Discharge','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'Testicular Swelling','category_id' => 6]);
        $symptom = Symptom::create(['name' => 'Testicular Pain','category_id' => 6]);

        $symptom = Symptom::create(['name' => 'Bleeding','category_id' => 7]);
        $symptom = Symptom::create(['name' => 'Itching','category_id' => 7]);
        $symptom = Symptom::create(['name' => 'Swelling','category_id' => 7]);
        $symptom = Symptom::create(['name' => 'Skin Rashes or Bumps','category_id' => 7]);
        $symptom = Symptom::create(['name' => 'Bruising or Discoloration','category_id' => 7]);
        $symptom = Symptom::create(['name' => 'Sores','category_id' => 7]);
        $symptom = Symptom::create(['name' => 'Bites','category_id' => 7]);

        $symptom = Symptom::create(['name' => 'Muscle Pain','category_id' => 8]);
        $symptom = Symptom::create(['name' => 'Limited Motion or Mobility','category_id' => 8]);
        $symptom = Symptom::create(['name' => 'Muscle Weakness','category_id' => 8]);
        $symptom = Symptom::create(['name' => 'Back Pain','category_id' => 8]);
        $symptom = Symptom::create(['name' => 'Swelling','category_id' => 8]);
        $symptom = Symptom::create(['name' => 'Joint Replacements','category_id' => 8]);
    }
}
