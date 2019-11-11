<?php

use Illuminate\Database\Seeder;

use App\Models\Emr\Prescription\PrescriptionFrequency;

class PrescriptionFrequencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $freq = PrescriptionFrequency::create(['name' => 'Four Times a Day (QID)']);
        $freq = PrescriptionFrequency::create(['name' => 'Three Times a Day (TID)']);
        $freq = PrescriptionFrequency::create(['name' => 'Twice a Day (BID)']);
        $freq = PrescriptionFrequency::create(['name' => 'Daily (OD)']);
        $freq = PrescriptionFrequency::create(['name' => 'Every Other Day (QOD)']);
        $freq = PrescriptionFrequency::create(['name' => 'Three Times a Week (TIW)']);
        $freq = PrescriptionFrequency::create(['name' => 'Twice a Week (BIW)']);
        $freq = PrescriptionFrequency::create(['name' => 'Weekly (QWK)']);
    }
}
