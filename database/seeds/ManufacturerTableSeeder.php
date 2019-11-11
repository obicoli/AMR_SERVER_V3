<?php

use Illuminate\Database\Seeder;
use App\Models\Manufacturer\Manufacturer;

class ManufacturerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Manufacturer::create(['name' => 'Acichem Laboratories']);
        Manufacturer::create(['name' => 'Jaskam & Company Ltd']);
        Manufacturer::create(['name' => 'Cosmos Pharmaceutical Limited']);
    }
}
