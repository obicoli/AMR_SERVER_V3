<?php

use Illuminate\Database\Seeder;
use App\Models\Consultation\Prescription\TestOrder;

class TestOrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ord = TestOrder::create(['name' => 'Lab']);
        $ord = TestOrder::create(['name' => 'Imaging']);
    }
}
