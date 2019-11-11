<?php

use Illuminate\Database\Seeder;
use \App\Models\Product\Order\OrderDeliveryStatus;

class OrderDeliveryStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderDeliveryStatus::create(['name' => 'processing']);
        OrderDeliveryStatus::create(['name' => 'dispatched']);
        OrderDeliveryStatus::create(['name' => 'arrived']);
        OrderDeliveryStatus::create(['name' => 'delivered']);
    }
}
