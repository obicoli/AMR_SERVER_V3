<?php

use Illuminate\Database\Seeder;
use App\Models\Emr\Prescription\PrescriptionRoute;

class PrescriptionRouteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presR = PrescriptionRoute::create(['name' => 'Oral']);
        $presR = PrescriptionRoute::create(['name' => 'Topical']);
        $presR = PrescriptionRoute::create(['name' => 'Sublingual']);
        $presR = PrescriptionRoute::create(['name' => 'Inhalation']);
        $presR = PrescriptionRoute::create(['name' => 'Injection']);
    }
}
