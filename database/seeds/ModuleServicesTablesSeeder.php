<?php

use Illuminate\Database\Seeder;
use \App\Models\Module\Module;
use \App\Models\Service\Service;

class ModuleServicesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Module::create(['name' => 'Patient']);
        Module::create(['name' => 'Doctor']);
        Module::create(['name' => 'Manufacture']);
        Module::create(['name' => 'Supplier']);
        Module::create(['name' => 'Pharmacy']);
        Module::create(['name' => 'Product']);
        Module::create(['name' => 'Practice']);

        $cld = Service::create(['name'=>'Calendar','slug'=>'calendar']);
        $cld->service_charge()->create(['service_type' => 'Regular E-Visit','cost' => 1500,'slug'=>'online']);
        $cld->service_charge()->create(['service_type' => 'Physical Visit','cost' => 500,'slug'=>'physical']);
        $inv = Service::create(['name'=>'Inventory','slug'=>'inventory']);
        $tn = Service::create(['name'=>'Treatment Notification (TN)','slug'=>'tn']);
        $emr = Service::create(['name'=>'Electronic Medical Record (EMR)','slug'=>'emr']);
    }
}
