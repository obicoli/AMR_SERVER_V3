<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        
        $this->call('PermissionsTableSeeder');
        $this->call('RolesTableSeeder');
        $this->call('ConnectRelationshipsSeeder');
        $this->call('ModuleServicesTablesSeeder');
        $this->call('HealthProfileTablesSeeder');
        
        //$this->call('PracticeRoleTableSeeder');
        $this->call('UsersTableSeeder');
        $this->call('AccountingTableSeeder');

        $this->call('TimezoneTableSeeder');
        $this->call('DomainTableSeeder');
        $this->call('SpecialistTableSeeder');
        $this->call('SymptomCategoryTableSeeder');
        $this->call('SymptomTableSeeder');
        //$this->call('ServiceTableSeeder');

        $this->call('CountryTableSeeder');
        $this->call('RegionTableSeeder');
        $this->call('CountyTableSeeder');
        $this->call('CityTableSeeder');

        $this->call('PrescriptionFormTableSeeder');
        $this->call('PrescriptionFrequencyTableSeeder');
        $this->call('PrescriptionRouteTableSeeder');
        $this->call('ExcusingActivityTableSeeder');
        $this->call('TestOrderTableSeeder');
        $this->call('ConsultClassificationTableSeeder');
        $this->call('ConsultDoctorActionTableSeeder');
        $this->call('ProductCategoryTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('OrderDeliveryStatusesTableSeeder');
        $this->call('HrTablesSeeder');
        $this->call('AssetSeeder');
        $this->call('DashboardWidgetSeeder');

        Model::reguard();
    }
}
