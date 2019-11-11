<?php

use Illuminate\Database\Seeder;
use App\Models\Emr\Notes\ExecuseActivity;

class ExcusingActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acti = ExecuseActivity::create(['name' => 'Work']);
        $acti = ExecuseActivity::create(['name' => 'School']);
        $acti = ExecuseActivity::create(['name' => 'Physical Activity']);
        $acti = ExecuseActivity::create(['name' => 'Other']);
    }
}
