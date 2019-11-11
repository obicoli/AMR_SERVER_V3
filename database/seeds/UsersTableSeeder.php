<?php

use App\Models\Supplier\Supplier;
use App\Models\Users\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;
use \Illuminate\Support\Facades\Hash;
use \App\Models\Users\Assets;
use App\Models\Patient\Patient;
use App\Models\Doctor\Doctor;
use \App\Models\Practice\Practice;
use \App\Models\Patient\HealthProfile;
use \App\Models\Pharmacy\Pharmacy;
use \App\Models\Product\ProductPracticeSupplier;
use App\Models\Practice\PracticeRole;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Hospital\Hospital;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed test admin
        // $seededAdminEmail = 'admin@admin.com';
        // $user = User::where('email', '=', $seededAdminEmail)->first();
        // $adminRole = Role::where('slug', '=', 'admin')->first();
        // if ($user === null) {
        //     $user = User::create([
        //         //'username'                     => 'obicoli',
        //         'email'                          => $seededAdminEmail,
        //         'mobile'                          => '254724220055',
        //         //'uuid'                          => '25470415142vbvbvFRDSWQSDT9',
        //         'password'                       => Hash::make('123'),
        //         'status'                      => 'Activated',
        //     ]);
        //     $user->attachRole($adminRole);
        // }

        // // Seed test user
        // $user = User::where('email', '=', 'patient@patient.com')->first();
        // if ($user === null) {
        //     $patient = new Patient();
        //     $patient->first_name = 'John';
        //     $patient->other_name = 'Doe';
        //     $patient->email = 'obicoooli@gmail.com';
        //     $patient->mobile = '254702294109';
        //     $user = User::create([
        //         //'username'                     => 'obicoli1',
        //         'email'                          => 'patient@patient.com',
        //         'mobile'                          => '254702294142',
        //         'password'                       => Hash::make('123'),
        //         'status'                      => 'Activated',
        //         //'uuid'                          => '25470415142v34343bvbvFRDSWQSDT9',
        //     ]);
        //     $user->patient()->save($patient);
        //     //attach patient role
        //     $rolePatient = Role::where('slug', '=', 'patient')->first();
        //     $user->attachRole($rolePatient);
        //     $user->assets()->save(new Assets());
        //     $patient->health_profile()->save(new HealthProfile());
        // }

        // // Seed test user
        // $user = User::where('email', '=', 'obicoali@gmail.com')->first();
        // if ($user === null) {
        //     $patient = new Patient();
        //     $patient->first_name = 'Ivyne';
        //     $patient->other_name = 'Elena';
        //     $patient->email = 'obicoali@gmail.com';
        //     $patient->mobile = '254702297772';
        //     $user = User::create([
        //         //'username'                     => 'obicoli1',
        //         'email'                          => 'obicoali@gmail.com',
        //         'mobile'                          => '254702297772',
        //         'password'                       => Hash::make('123'),
        //         'status'                      => 'Activated',
        //         //'uuid'                          => '25470415142v34343bvbvFRDSWQSDT9',
        //     ]);
        //     $user->patient()->save($patient);
        //     //attach patient role
        //     $rolePatient = Role::where('slug', '=', 'patient')->first();
        //     $user->attachRole($rolePatient);
        //     $user->assets()->save(new Assets());
        //     $patient->health_profile()->save(new HealthProfile());
        // }

        // // Seed test user
        // $user = User::where('email', '=', 'patient2@patient.com')->first();
        // if ($user === null) {
        //     $patient = new Patient();
        //     $patient->first_name = 'John';
        //     $patient->other_name = 'Doe';
        //     $patient->email = 'patient2@patient.com';
        //     $patient->mobile = '254702297654';
        //     $user = User::create([
        //         //'username'                     => 'obicoli1',
        //         'email'                          => 'patient2@patient.com',
        //         'mobile'                          => '254702297654',
        //         'password'                       => Hash::make('123'),
        //         'status'                      => 'Activated',
        //         //'uuid'                          => '25470415142v34343bvbvFRDSWQSDT9',
        //     ]);
        //     $user->patient()->save($patient);
        //     //attach patient role
        //     $rolePatient = Role::where('slug', '=', 'patient')->first();
        //     $user->attachRole($rolePatient);
        //     $user->assets()->save(new Assets());
        //     $patient->health_profile()->save(new HealthProfile());
        // }

        // $user = User::where('email', '=', 'doctor@doctor.com')->first();
        // if ($user === null) {
        //     $doctor = new Doctor();
        //     $doctor->first_name = 'Borne';
        //     $doctor->other_name = 'Breaker';
        //     $doctor->gender = 'Male';
        //     $doctor->email = 'doctor@doctor.com';
        //     $doctor->mobile = '254702294144';
        //     $doctor->title = 'Dr';
        //     $user = User::create([
        //         //'username'                     => 'obicoli12',
        //         'email'                          => 'doctor@doctor.com',
        //         'mobile'                          => '254702294144',
        //         'password'                       => Hash::make('123'),
        //         'status'                      => 'Activated',
        //     ]);
        //     $user->doctor()->save($doctor);
        //     $practice = new Practice();
        //     $practice->name = 'Eben Chemistry';
        //     $practice->city = 'Nairobi';
        //     $practice->country = 'Kenya';
        //     $practice->website = 'www.afyamkononi.com';
        //     $practice->registration_number = '432-123';
        //     $practice->longitude = 36.92316;
        //     $practice->latitude = -1.31817;
        //     $practice->type = 'Chemistry';
        //     $practice->approval_status = 'approved';
        //     $practice->status = true;
        //     $practice->mobile = '+254709876543';
        //     $practice->email = 'pharmacy@pharmacy.com';
        //     $practice->address = 'OUTERING RD. 100m Fr Donhom ST ANCHORAGE AK, 99501';
        //     $doctor->practices()->save($practice);
        //     //attach doctor role
        //     $roleDoctor = Role::where('slug', '=', 'doctor')->first();
        //     $user->attachRole($roleDoctor);
        // }

        // // Seed test admin
        // $seededAdminEmail = 'manufacturer@manufacturer.com';
        // $user = User::where('email', '=', $seededAdminEmail)->first();
        // $adminRole = Role::where('slug', '=', 'manufacturer')->first();
        // if ($user === null) {
        //     $user = User::create([
        //         //'username'                     => 'manufacturer',
        //         'email'                          => $seededAdminEmail,
        //         'mobile'                          => '254724220050',
        //         'password'                       => Hash::make('123'),
        //         'status'                      => 'Activated',
        //     ]);
        //     $user->attachRole($adminRole);
        //     //$user->assets()->save(new Assets());
        //     $manu1 = \App\Models\Manufacturer\Manufacturer::create([
        //         'name' => 'Fab, Par: Dawa Limited',
        //         'slug' => 'GlaxoSmithKlines',
        //         'uuid' => 'gsk09',
        //     ]);
        //     $manu2 = \App\Models\Manufacturer\Manufacturer::create([
        //         'name' => 'GSK GlaxoSmithKliness',
        //         'slug' => 'GlaxoSmithKliness',
        //         'uuid' => 'gsk091',
        //     ]);
        //     $manu = \App\Models\Manufacturer\Manufacturer::create([
        //         'name' => 'SmithKline Beecham Limited',
        //         'slug' => 'GlaxoSmithKline',
        //         'uuid' => 'gsk092',
        //     ]);
        //     $manu->profile()->create([
        //         'logo'=>'/assets/images/profile/logo/gsk.png',
        //         'contact_email'=>'gsk@email.com',
        //         'phone'=>'+254700000000',
        //         'city'=>'Nairobi',
        //         'country'=>'Kenya',
        //     ]);
        //     $manu1->profile()->create([
        //         'logo'=>'/assets/images/profile/logo/gsk.png',
        //         'contact_email'=>'gsk1@email.com',
        //         'phone'=>'+254700000001',
        //         'city'=>'Nairobi',
        //         'country'=>'Kenya',
        //     ]);
        //     $manu2->profile()->create([
        //         'logo'=>'/assets/images/profile/logo/gsk.png',
        //         'contact_email'=>'gsk2@email.com',
        //         'phone'=>'+254700000002',
        //         'city'=>'Nairobi',
        //         'country'=>'Kenya',
        //     ]);
        // }

        $user = User::where('email', '=', 'amref@amref.com')->first();
        if ($user === null) {
            //SET A HOSPITAL
            $pharmacy = new Hospital();
            $pharmacy->name = 'AMREF Enterprises | AMREF Health Africa';
            $pharmacy->city = 'Nairobi';
            $pharmacy->country = 'Kenya';
            $pharmacy->website = 'www.amref.com';
            $pharmacy->registration_number = '432-12398';
            $pharmacy->longitude = 36.92316;
            $pharmacy->latitude = -1.31817;
            $pharmacy->postal_code = '1000096';
            $pharmacy->approval_status = 'approved';
            $pharmacy->phone = '+254709876590';
            $pharmacy->logo = '/assets/images/profile/logo/amref_logo.png';
            $pharmacy->contact_email = 'amref@afyamkononi.com';
            $pharmacy->address = 'Langata Rd ST ANCHORAGE AK, 99501';
            $user = User::create([
                'email'                          => 'admin2@amref.com',
                'mobile'                          => '254702294190',
                'password'                       => Hash::make('Bytech123'),
                'status'                      => 'Activated',
            ]);
            $user->pharmacy()->save($pharmacy);
            $pharmacyRole = Role::where('slug', '=', 'pharmacy')->first();
            $user->attachRole($pharmacyRole);
            $store = $pharmacy->practices()->create([
                // 'type'=>'Pharmacy',
                'country'=>'Kenya',
                'city'=>'Nairobi',
                'category'=>'Main',
                'address'=>'Langata Rd ST ANCHORAGE AK, 99501',
                'approval_status'=>'approved',
                'status'=>true,
                'postal_code' => '9000010',
                'latitude'=>-1.319256,////
                'longitude' => 36.809858,////
                'registration_number'=>'432-12398',
                'name'=>'AMREF Wilson Airport',
                'email'=>'amref@afyaamkaononi.com',
                'support_email'=>'amraaef@amref.com',
                'mobile'=>2547098722222,
            ]);
            $settings1 = $store->practice_finance_settings()->create(['so_prefix'=>'2019-SO-']);
            $store2 = $pharmacy->practices()->create([
                // 'type'=>'Pharmacy',
                'country'=>'Kenya',
                'city'=>'Nairobi',
                'category'=>'Branch',
                'address'=>'Kibera, Mara road, Westy',
                'approval_status'=>'approved',
                'status'=>true,
                'postal_code' => '9000009',
                'latitude'=>-1.287232,////
                'longitude' => 36.6982105,////
                'registration_number'=>'432-1230999',
                'name'=>'Kibera Community Health Centre-Amref',
                'email'=>'kibera@amref.com',
                'support_email'=>'kibera@amref.com',
                'mobile'=>254709879999,
            ]);
            $settings1 = $store2->practice_finance_settings()->create(['so_prefix'=>'2019-SO-']);
            $facility_upperhill = $pharmacy->practices()->create([
                // 'type'=>'Pharmacy',
                'country'=>'Kenya',
                'city'=>'Nairobi',
                'category'=>'Branch',
                'address'=>'Mara road, UpperHill',
                'approval_status'=>'approved',
                'status'=>true,
                'postal_code' => '9000008',
                'latitude'=>-1.2858812,////
                'longitude' => 36.7973609,////
                'registration_number'=>'432-12300',
                'name'=>'Amref Enterprises Limited',
                'email'=>'amrefupperhill@amref.com',
                'support_email'=>'amrefupperhill@amsref.com',
                'mobile'=>254709811111,
            ]);
            $settings1 = $facility_upperhill->practice_finance_settings()->create(['so_prefix'=>'2019-SO-']);
            $facility_buru = $pharmacy->practices()->create([
                // 'type'=>'Pharmacy',
                'country'=>'Kenya',
                'city'=>'Nairobi',
                'category'=>'Branch',
                'address'=>'Mara road, Buruburu',
                'approval_status'=>'approved',
                'status'=>true,
                'postal_code' => '90000028333',
                'latitude'=>-1.283939,
                'longitude'=>36.879508,
                'registration_number'=>'432-123100444',
                'name'=>'AMREF Buruburu',
                'email'=>'amrefburubauru@amref.com',
                'support_email'=>'amrefburuburu@amsref.com',
                'mobile'=>254709876323333,
            ]);
            $settings1 = $facility_buru->practice_finance_settings()->create(['so_prefix'=>'2019-SO-']);

            //SET HOSPITAL/ENTERPRISE DEPARTMENT/Add Departiments to ENTERPRISE
            // $pharmacy->departments()->create(['name'=>'Procurement']);
            // $pharmacy->departments()->create(['name'=>'Finance']);
            // $pharmacy->departments()->create(['name'=>'Pharmacy']);
            // $pharmacy->departments()->create(['name'=>'Laboratory']);
            // $pharmacy->departments()->create(['name'=>'Imaging']);
            // $pharmacy->departments()->create(['name'=>'Stores']);
            // $pharmacy->departments()->create(['name'=>'Transport']);
            // $pharmacy->departments()->create(['name'=>'Nursing']);
            // $pharmacy->departments()->create(['name'=>'Pathology']);
            // $pharmacy->departments()->create(['name'=>'Radiodology']);
            //Stores
            $practice1 = Practice::find(1);
            $practice2 = Practice::find(2);
            $practice3 = Practice::find(3);
            $practice4 = Practice::find(4);
            $store1 = $pharmacy->stores()->create(['name'=>'KCO Main Store','type'=>'main']);
            $sub_store = $pharmacy->stores()->create(['name'=>'Pharmacy','type'=>'sub store']);
            $practice1->stores()->save($store1);
            $practice1->stores()->save($sub_store);
            //Amref westlands Pharmacy Sub store
            $store_westlands = $pharmacy->stores()->create(['name'=>'Kibera Store','type'=>'main']);
            $sub_store1 = $pharmacy->stores()->create(['name'=>'Pharmacy','type'=>'sub store']);
            $practice2->stores()->save($sub_store1);
            $practice2->stores()->save($store_westlands);
            //Amref Upperhill Pharmacy Sub store
            $store_upperhil = $pharmacy->stores()->create(['name'=>'Upper Hill Store','type'=>'main']);
            $sub_store_upperhil = $pharmacy->stores()->create(['name'=>'Pharmacy','type'=>'sub store']);
            $practice3->stores()->save($sub_store_upperhil);
            $practice3->stores()->save($store_upperhil);
            //Amref Buru Pharmacy Sub store
            $store_buruburu = $pharmacy->stores()->create(['name'=>'Buruburu Store','type'=>'main']);
            $sub_store_buru = $pharmacy->stores()->create(['name'=>'Pharmacy','type'=>'sub store']);
            $facility_buru->stores()->save($store_buruburu);
            $facility_buru->stores()->save($sub_store_buru);
            //Add Departiments to Facility
            // $departments = $pharmacy->departments()->get();
            // foreach($departments as $department){
            //     $practice1->departments()->save($department);
            //     $practice2->departments()->save($department);
            //     $practice3->departments()->save($department);
            //     $facility_buru->departments()->save($department);
            // }

            //$hospital = Hospital::find(1);
            $practica = $pharmacy->practices()->where('category','Main')->get()->first();
            PracticeRole::create([
                'practice_id' => $practica->id,
                'slug' => 'master.admin',
                'name' => 'Master admin',
                'description' => 'System Adminstrator',
            ]);
            PracticeRole::create([
                'practice_id' => $practica->id,
                'slug' => 'general.manager',
                'name' => 'General Manager',
                'description' => 'Main Branch Manager. Can manage all branches',
            ]);
            PracticeRole::create([
                'practice_id' => $practica->id,
                'slug' => 'branch.manager',
                'name' => 'Branch Manager',
                'description' => 'Sub branch Manager. Manages all activities at branch level',
            ]);
            PracticeRole::create([
                'practice_id' => $practica->id,
                'slug' => 'pharmacist',
                'name' => 'Pharmacist',
                'description' => 'Pharmacy. Manages all activities at Pharmacy',
            ]);
            
            $practiceMasterRole = PracticeRole::all()->where('slug','master.admin')->first();
            //$generalManagerRole = PracticeRole::all()->where('slug','general.manager')->first();
            // $branchManagerRole = PracticeRole::all()->where('slug','branch.manager')->first();
            // $pharmacistRole = PracticeRole::all()->where('slug','pharmacist')->first();

            $permissions = Permission::all();
            foreach($permissions as $permission){
                $practiceMasterRole->attachPermission($permission);
                //$generalManagerRole->attachPermission($permission);
                //$branchManagerRole->attachPermission($permission);
                //$pharmacistRole->attachPermission($permission);
                // if( ($permission->slug=="create.branch") || ($permission->slug=="edit.branch") || ($permission->slug=="view.branch") || ($permission->slug=="delete.branch") ){
                // }else{
                //     $branchManagerRole->attachPermission($permission);
                //     $pharmacistRole->attachPermission($permission);
                // }
            }

            //Adding Users to facilities
            $user1 = User::create([
                'email'                          => 'master@amref.com',
                'mobile'                          => '254709098765',
                'password'                       => Hash::make('master123'),
                'status'                      => 'Activated',
            ]);
            // $user2 = User::create([
            //     'email'                          => 'generalmanager@amref.com',
            //     'mobile'                          => '254709098700',
            //     'password'                       => Hash::make('Bytech123'),
            //     'status'                      => 'Activated',
            // ]);
            // $user3 = User::create([
            //     'email'                          => 'westlanduser@amref.com',
            //     'mobile'                          => '254709098799',
            //     'password'                       => Hash::make('Bytech123'),
            //     'status'                      => 'Activated',
            // ]);
            // $user4 = User::create([
            //     'email'                          => 'upperhilluser@amref.com',
            //     'mobile'                          => '254709098222',
            //     'password'                       => Hash::make('Bytech123'),
            //     'status'                      => 'Activated',
            // ]);
            // $user_buru = User::create([
            //     'email'                          => 'pharmacist.buru@amref.com',
            //     'mobile'                          => '254700123456',
            //     'password'                       => Hash::make('Bytech123'),
            //     'status'                      => 'Activated',
            // ]);
            $store_user_main = $store->users()->create([
                'practice_id' => $store->id,
                'user_id' => $user1->id,
                'first_name' => 'Peter',
                'email' => 'master@amref.com',
                'facility' => false,
                'mobile' => '254709098765',
                'other_name' => 'Doe',
                'gender' => 'Male',
                'password' => Hash::make('master123'),
                'address' => 'Nairobi, Kenya',
                //'department_id' => $user1->id,
            ]);
            // $store_user2 = $store->users()->create([
            //     'practice_id' => $store->id,
            //     'user_id' => $user2->id,
            //     'first_name' => 'Alex',
            //     'email' => 'generalmanager@amref.com',
            //     'mobile' => '254700666666',
            //     'other_name' => 'Muanda',
            //     'gender' => 'Male',
            //     'password' => Hash::make('Bytech123'),
            //     'address' => 'Nairobi, Kenya',
            //     //'department_id' => $user1->id,
            // ]);
            // $store_user3 = $store2->users()->create([
            //     'practice_id' => $store2->id,
            //     'user_id' => $user3->id,
            //     'first_name' => 'Hassan',
            //     'email' => 'westlanduser@amref.com',
            //     'mobile' => '254700999999',
            //     'other_name' => 'Mohamed',
            //     'gender' => 'Male',
            //     'password' => Hash::make('Bytech123'),
            //     'address' => 'Nairobi, Kenya',
            //     //'department_id' => $user1->id,
            // ]);
            // $store_user_upperhil = $facility_upperhill->users()->create([
            //     'practice_id' => $facility_upperhill->id,
            //     'user_id' => $user4->id,
            //     'first_name' => 'Joreem',
            //     'email' => 'upperhilluser@amref.com',
            //     'mobile' => '254700999999',
            //     'other_name' => 'Mikobia',
            //     'gender' => 'Male',
            //     'password' => Hash::make('Bytech123'),
            //     'address' => 'Nairobi, Kenya',
            //     //'department_id' => $user1->id,
            // ]);
            //Pharmacist Buruburu
            // $store_user_buru = $facility_buru->users()->create([
            //     'practice_id' => $facility_buru->id,
            //     'user_id' => $user_buru->id,
            //     'first_name' => 'John',
            //     'email' => 'pharmacist.buru@amref.com',
            //     'mobile' => '254700123456',
            //     'other_name' => 'Doe',
            //     'gender' => 'Male',
            //     'password' => Hash::make('Bytech123'),
            //     'address' => 'Nairobi, Kenya',
            //     //'department_id' => $user1->id,
            // ]);

            //$departmen = $pharmacy->departments()->where('name','Pharmacy')->get()->first();
            $work_area_main = $store_user_main->work_place()->create([
                'practice_id'=>$store->id,
                'department_id'=>1,
                'store_id'=>$store1->id,
                'sub_store_id'=>$sub_store->id,
            ]);//Add User to KCO Main Store
            $user1->company_id = $store->id;
            $user1->department_id = 1;
            $user1->store_id = $store1->id;
            $user1->sub_store_id = $sub_store->id;
            $user1->company_user_id = $store_user_main->id;
            $user1->save();
            
            // $work_area = $store_user_buru->work_place()->create([
            //     'practice_id'=>$facility_buru->id,
            //     'department_id'=>$departmen->id,
            //     'store_id'=>$store_buruburu->id,
            //     'sub_store_id'=>$sub_store_buru->id,
            // ]);//Add User to Pharmacy Department
            // //$store_user_buru->stores()->save($sub_store_buru);//Add User to Buruburu Store
            // $work_area_upperhill = $store_user_upperhil->work_place()->create([
            //     'practice_id'=>$facility_upperhill->id,
            //     'department_id'=>$departmen->id,
            //     'store_id'=>$store_upperhil->id,
            //     'sub_store_id'=>$sub_store_upperhil->id,
            // ]);//Add User to Pharmacy Department

            $practiceMasterRole->attachPermission($permission);
            $store_user_main->attachRole($practiceMasterRole);

            // $store_user2->attachRole($generalManagerRole);
            // $store_user3->attachRole($branchManagerRole);
            // $store_user_upperhil->attachRole($pharmacistRole);
            // $store_user_buru->attachRole($pharmacistRole);

            // $permissions = \jeremykenedy\LaravelRoles\Models\Permission::all();
            // foreach ($permissions as $permission){
            //     $store_user->attachPermission($permission);
            // }
            // $store_user->profile()->create([
            //     'first_name' => 'Collins',
            //     'other_name' => 'Obonyo',
            //     'email' => 'salesman@afyamkononi.com',
            //     'mobile' => '254709098765',
            // ]);
        }

        // $supplier = Supplier::create([
        //     'name'=>'Abc corp Ltd',
        //     'phone'=>'254700000000',
        //     'email'=>'supplier@suppliers.com',
        //     'address'=>'Nairobi, Kenya',
        //     'logo'=>'/assets/images/profile/logo/pepsino.png',
        // ]);
        // $supplier->practices()->save(new Practice());
        // $supplier2 = Supplier::create([
        //     'name'=>'Pepsico Ltd',
        //     'phone'=>'254700000001',
        //     'email'=>'pepsico@gmail.com',
        //     'address'=>'Nairobi, Kenya',
        //     'logo'=>'/assets/images/profile/logo/gsk.png',
        // ]);
        // $supplier2->practices()->save(new Practice());

        //jeffdaniels950@gmail.com
        //vnyamunga@gmail.com
        //paulkkutto@gmail.com
        //obicoli@gmail.com
        //awanjiru87@gmail.com
        //mugalo@gmail.com
        //isaac.muli@amref.org
        //lemmy.kiarie@amref.org

    }
}
