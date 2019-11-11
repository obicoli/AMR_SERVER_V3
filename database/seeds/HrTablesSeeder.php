<?php

use App\Hrs\Models\Employee\HrsDepartment;
use App\Hrs\Models\Employee\HrsJob;
use App\Hrs\Models\Employee\HrsRegion;
use App\Hrs\Models\Employee\HrsEmployee;
use App\Models\Hospital\Hospital;
use Illuminate\Database\Seeder;

class HrTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Hr Jobs
        // HrsJob::create(['job_title'=>'Doctor']);
        // 
        // HrsJob::create(['job_title'=>'Accountant']);
        // HrsJob::create(['job_title'=>'Laboratorist']);
        // HrsJob::create(['job_title'=>'Nurse']);
        // $pharma = HrsJob::create(['job_title'=>'Pharmacist']);
        // HrsJob::create(['job_title'=>'Receptionist']);
        // $case_manager = HrsJob::create(['job_title'=>'Case Manager']);
        // $pharmacy_manager = HrsJob::create(['job_title'=>'Pharmacy Manager']);
        // $facility_manager = HrsJob::create(['job_title'=>'Facility Manager']);
        // $facility_stock_manager = HrsJob::create(['job_title'=>'Facility Stock Manager']);
        // HrsJob::create(['job_title'=>'Representative']);
        //

        //Hr Departments
        // $dep_proc = $location1->departments()->save(HrsDepartment::create(['name'=>'Procurement']));
        // $dep_pharm = $location1->departments()->save(HrsDepartment::create(['name'=>'Pharmacy']));
        // $dep_lab = $location1->departments()->save(HrsDepartment::create(['name'=>'Laboratory']));
        // $dep_img = $location1->departments()->save(HrsDepartment::create(['name'=>'Imaging']));
        // $dep_store = $location1->departments()->save(HrsDepartment::create(['name'=>'Stores']));
        // 
        // $dep_nurse = $location1->departments()->save(HrsDepartment::create(['name'=>'Nursing']));
        // $dep_path = $location1->departments()->save(HrsDepartment::create(['name'=>'Pathology']));
        // $dep_radio = $location1->departments()->save(HrsDepartment::create(['name'=>'Radiodology']));

        //Employees: Driver
        // $trans_manager = $transport_manager_empl->managers()->create(['status'=>'Active']);

        //Enter price
        $hospital = Hospital::find(1);
        $facility = $hospital->practices()->where('category','Main')->get()->first();
        //============================================================================================
        //Create a Regions
        $east_region = HrsRegion::create(['name'=>'East Africa']);
        //Create a Country
        $kenya = $east_region->countries()->create(['name'=>'Kenya','code'=>'KE','currency'=>'Kenyan shilling','currency_sympol'=>'KES']);
        $east_region->countries()->create(['name'=>'Australia','code'=>'AUD','currency'=>'Australian dollar','currency_sympol'=>'AUD']);
        //Locations
        $location1 = $kenya->locations()->create(['state_province'=>'Nairobi','city'=>'Nairobi','postal_code'=>'30125, 00100','street_address'=>"Lang'ata Road, Wilson Airport"]);
        //Create Job Title
        $finance_manager = HrsJob::create(['job_title'=>'Finance Manager']);
        //Link Finance Department to a location
        $dep_fina = $location1->departments()->save(HrsDepartment::create(['name'=>'Finance']));
        $dep_trans = $location1->departments()->save(HrsDepartment::create(['name'=>'Transport']));
        //Finance Manager Employee
        $finance_manager_empl = HrsEmployee::create([
            'first_name'=>'John',
            'last_name'=>'Doe',
            'other_name'=>'Deo',
            'email'=>'finance@manager.com',
            'phone'=>'254709890222',
        ]);
        $hospital->employees()->save($finance_manager_empl);
        $facility->employees()->save($finance_manager_empl);
        //Link Finance employee with job Title: Finance Manager
        $finance_manager->employees()->save($finance_manager_empl);
        //Link Employee to Manager
        $fina_manager = $finance_manager_empl->managers()->create(['status'=>'Active']);
        //Link manager to Department
        $dep_fina->managers()->save($fina_manager);
        //Link Employee to Department
        $dep_fina->employees()->save($finance_manager_empl);
        //============================================================================================

        //================================Creating Driver=============================================
        //Create a Regions
        //$east_region = HrsRegion::create(['name'=>'East Africa']);
        //Create a Country
        //$kenya = $east_region->countries()->create(['name'=>'Kenya','code'=>'KE','currency'=>'KES']);
        //Locations
        //$location1 = $kenya->locations()->create(['state_province'=>'Nairobi','city'=>'Nairobi','postal_code'=>'30125, 00100','street_address'=>"Lang'ata Road, Wilson Airport"]);
        //Create Job Title
        $transport_manager = HrsJob::create(['job_title'=>'Transport Manager']);
        $driver = HrsJob::create(['job_title'=>'Driver']);
        //Link Transport Department to a location
        $dep_trans = $location1->departments()->save(HrsDepartment::create(['name'=>'Transport']));
        //Finance Manager Employee
        $transport_manager_empl = HrsEmployee::create([
            'first_name'=>'John',
            'last_name'=>'Doe',
            'other_name'=>'Deo',
            'email'=>'transport@manager.com',
            'phone'=>'254709890893',
        ]);
        $hospital->employees()->save($transport_manager_empl);
        $facility->employees()->save($transport_manager_empl);
        $driver_empl = HrsEmployee::create([
            'first_name'=>'John',
            'last_name'=>'Driver',
            'other_name'=>'Deo',
            'email'=>'driver@amref.com',
            'phone'=>'254700000001',
        ]);
        $hospital->employees()->save($driver_empl);
        $facility->employees()->save($driver_empl);
        $driver_empl2 = HrsEmployee::create([
            'first_name'=>'John',
            'last_name'=>'John',
            'other_name'=>'John',
            'email'=>'driver2@amref.com',
            'phone'=>'254700000002',
        ]);
        $hospital->employees()->save($driver_empl2);
        $facility->employees()->save($driver_empl2);
        
        //Link Finance employee with job Title: Finance Manager
        $transport_manager->employees()->save($transport_manager_empl);
        //Link Driver with Job Title
        $driver->employees()->save($driver_empl);
        $driver->employees()->save($driver_empl2);
        //Link Employee to Manager
        $transport_manager = $transport_manager_empl->managers()->create(['status'=>'Active']);
        //Link manager to Department
        $dep_trans->managers()->save($transport_manager);
        //Link Employee to Department
        $dep_trans->employees()->save($transport_manager_empl);
        $dep_trans->employees()->save($driver_empl);
        $dep_trans->employees()->save($driver_empl2);
        //============================================================================================

        // $store_manager_empl = HrsEmployee::create([
        //     'first_name'=>'John',
        //     'last_name'=>'Doe',
        //     'other_name'=>'Deo',
        //     'email'=>'store@manager.com',
        //     'phone'=>'254709890111',
        // ]);
        // $store_manager = $store_manager_empl->managers()->create(['status'=>'Active']);
        // $driver_empl = HrsEmployee::create([
        //     'first_name'=>'John',
        //     'last_name'=>'Doe',
        //     'other_name'=>'Deo',
        //     'email'=>'driver1@amref.com',
        //     'phone'=>'254709890890',
        // ]);
        // $driver_empl = HrsEmployee::create([
        //     'first_name'=>'Joreem',
        //     'last_name'=>'Doe',
        //     'other_name'=>'Deo',
        //     'email'=>'driver2@amref.com',
        //     'phone'=>'254709890895',
        // ]);


    }
}
