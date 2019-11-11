<?php

use Illuminate\Database\Seeder;
use \App\Models\Specialist\Domains;

class DomainTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Domains::create(['name' => 'General Practice']);
        $category = Domains::create(['name' => 'Specialist']);
        $category = Domains::create(['name' => 'Allied Health']);
    }
}
