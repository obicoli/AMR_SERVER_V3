<?php

use Illuminate\Database\Seeder;

use App\Models\Symptom\SymptomCategory;

class SymptomCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = SymptomCategory::create(['name' => 'General Symptoms']);
        $category = SymptomCategory::create(['name' => 'Chest']);
        $category = SymptomCategory::create(['name' => 'Digestive Track']);
        $category = SymptomCategory::create(['name' => 'Medical Conditions']);
        $category = SymptomCategory::create(['name' => 'Head/Neck Symptoms']);
        $category = SymptomCategory::create(['name' => 'Pelvis']);
        $category = SymptomCategory::create(['name' => 'Skin']);
        $category = SymptomCategory::create(['name' => 'Muscles & Joints']);
    }
}
