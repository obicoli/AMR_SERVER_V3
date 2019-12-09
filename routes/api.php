<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group( ['prefix'=>'oauth', 'middleware' => ['cors'] ], function (){

    Route::group( ['middleware' => ['auth:api'] ], function (){
        Route::post('/logout', "Api\Auth\AuthController@logout");
        Route::post('/change/password', "Api\Auth\AuthController@changepassword");
    });
    //api for facility registration/login
    Route::post('/login/{source_type}', "Api\Auth\AuthController@login");
    Route::post('/invitation', "Api\Auth\AuthController@invitation");
    Route::post('/privileges', "Api\Auth\AuthController@privilege");
    Route::get('/invitation/users/{uuid}/{practice_uuid}', "Api\Auth\AuthController@show");
    Route::get('/resend/reset/link/{email}', "Api\Auth\ActivationController@resendLink");
    Route::get('/activate/{email}', "Api\Auth\ActivationController@activate");
    Route::get('/check/{uuid}', "Api\Auth\ActivationController@getUser");
    Route::post('/reset/password', "Api\Auth\ActivationController@reset");
    Route::post('/create/password', "Api\Auth\ActivationController@create");
    Route::post('/create/password/{uuid}', "Api\Auth\ActivationController@create_password");
    Route::post('/register', "Api\Auth\AuthController@register");
    //OTP
    Route::post('/resend/otp', "Api\Auth\ActivationController@resendOtp");
    Route::post('/verify/otp', "Api\Auth\ActivationController@verifyOtp");
});

Route::group( ['prefix'=>'localization', 'middleware' => ['cors'] ], function (){
    Route::group( [ 'prefix'=>'timezones' ], function (){
        Route::get('/', "Api\Localization\TimezoneController@index");
    });
    Route::group( [ 'prefix'=>'countries' ], function (){
        Route::get('/', "Api\Localization\CountryController@index");
    });
    Route::group( [ 'prefix'=>'counties' ], function (){
        Route::get('/', "Api\Localization\CountyController@index");
        Route::get('/{uuid}', "Api\Localization\CountyController@show");
        Route::delete('/{uuid}', "Api\Localization\CountyController@delete");
    });
    Route::group( [ 'prefix'=>'cities' ], function (){
        Route::get('/', "Api\Localization\CityController@index");
        Route::get('/{uuid}', "Api\Localization\CityController@show");
        Route::delete('/{uuid}', "Api\Localization\CityController@delete");
        Route::get('/country/{name}', "Api\Localization\CityController@country");
    });
});

Route::group( ['prefix'=>'domains', 'middleware' => ['cors'] ], function (){
    //api for facility registration/login
    Route::post('/', "Api\Specialist\SpecialistController@index");
    Route::get('/', "Api\Specialist\DomainController@index");
    Route::get('/specialist/{domain_id}', "Api\Specialist\SpecialistController@getSpecialistByDomain");
    Route::group( [ 'prefix'=>'specializations' ], function (){
        Route::get('/', "Api\Specialist\SpecialistController@index");
    });
});

Route::group( ['middleware' => ['auth:api','cors'] ], function (){

    //SYMPTOMS APIs
    Route::group( ['prefix'=>'symptoms' ], function (){
        Route::group( ['prefix'=>'categories' ], function (){
            Route::get('/', "Api\Symptom\CategoryController@index");
        });
        //Route::get('/', "Api\Symptom\SymptomController@index");
    });

    //ROLES APIs
    Route::group( ['prefix'=>'roles' ], function (){
        //api for facility registration/login
        Route::get('/', "Api\Users\RoleController@index");
        Route::get('/{id}', "Api\Users\RoleController@show");
        Route::post('/', "Api\Users\RoleController@store");
        Route::delete('/{id}', "Api\Users\RoleController@destroy");
        Route::put('/{id}', "Api\Users\RoleController@update");
        Route::get('/description/{description}', "Api\Users\RoleController@by_description");
    });

    Route::group( ['prefix'=>'permissions' ], function (){
        //api for facility registration/login
        Route::get('/', "Api\Users\PermissionController@index");
        Route::get('/{id}', "Api\Users\PermissionController@show");
        Route::post('/', "Api\Users\PermissionController@store");
        Route::delete('/{id}', "Api\Users\PermissionController@destroy");
    });

    Route::group( ['prefix'=>'delivery' ], function (){
        Route::group( ['prefix'=>'address' ], function (){
            //api for facility registration/login
            Route::get('/', "Api\Addresses\DeliveryAddressController@index");
            Route::get('/{id}', "Api\Addresses\DeliveryAddressController@show");
            Route::post('/', "Api\Addresses\DeliveryAddressController@store");
            Route::post('/{uuid}', "Api\Addresses\DeliveryAddressController@update");
            Route::delete('/{id}', "Api\Addresses\DeliveryAddressController@destroy");
            Route::put('/{id}', "Api\Addresses\DeliveryAddressController@update");
        });
    });

    //USERS API STARTS HERE
    Route::group( ['prefix'=>'doctors' ], function (){
        Route::get('/', "Api\Doctor\DoctorController@index");
        Route::get('/{uuid}', "Api\Doctor\DoctorController@show");
        Route::post('/{uuid}', "Api\Doctor\DoctorController@update");
        Route::post('/', "Api\Doctor\DoctorController@create");
        Route::delete('/{uuid}', "Api\Doctor\DoctorController@delete");
    });

    Route::group( ['prefix'=>'patients' ], function (){

        Route::group( ['prefix'=>'history' ], function (){

            Route::group( ['prefix'=>'health' ], function (){
                Route::get('/', "Api\Patient\HealthHistoryController@index");
                Route::post('/{uuid}', "Api\Patient\HealthHistoryController@update");
                Route::post('/', "Api\Patient\HealthHistoryController@create");
                Route::get('/{uuid}', "Api\Patient\HealthHistoryController@show");
                Route::delete('/{uuid}', "Api\Patient\HealthHistoryController@destroy");
            });

            Route::group( ['prefix'=>'conditions' ], function (){
                Route::get('/', "Api\Patient\PatientConditionController@index");
                Route::post('/{uuid}', "Api\Patient\PatientConditionController@update");
                Route::post('/', "Api\Patient\PatientConditionController@create");
                Route::get('/{uuid}', "Api\Patient\PatientConditionController@show");
                Route::delete('/{patient_uuid}/{condition_uuid}', "Api\Patient\PatientConditionController@destroy");
            });

            Route::group( ['prefix'=>'medications' ], function (){
                Route::get('/', "Api\Patient\PatientMedicationController@index");
                Route::post('/{uuid}', "Api\Patient\PatientMedicationController@update");
                Route::post('/', "Api\Patient\PatientMedicationController@create");
                Route::get('/{uuid}', "Api\Patient\PatientMedicationController@show");
                Route::delete('/{patient_uuid}/{condition_uuid}', "Api\Patient\PatientMedicationController@destroy");
            });

            Route::group( ['prefix'=>'allergies' ], function (){
                Route::get('/', "Api\Patient\PatientAllergyController@index");
                Route::post('/{uuid}', "Api\Patient\PatientAllergyController@update");
                Route::post('/', "Api\Patient\PatientAllergyController@create");
                Route::get('/{uuid}', "Api\Patient\PatientAllergyController@show");
                Route::delete('/{patient_uuid}/{condition_uuid}', "Api\Patient\PatientAllergyController@destroy");
            });

            Route::group( ['prefix'=>'surgeries' ], function (){
                Route::get('/', "Api\Patient\PatientSurgeryController@index");
                Route::post('/{uuid}', "Api\Patient\PatientSurgeryController@update");
                Route::post('/', "Api\Patient\PatientSurgeryController@create");
                Route::get('/{uuid}', "Api\Patient\PatientSurgeryController@show");
                Route::delete('/{patient_uuid}/{condition_uuid}', "Api\Patient\PatientSurgeryController@destroy");
            });

        });

        Route::get('/', "Api\Patient\PatientController@index");
        Route::post('/{uuid}', "Api\Patient\PatientController@update");
        Route::post('/', "Api\Patient\PatientController@create");
        Route::get('/{uuid}', "Api\Patient\PatientController@show");
        Route::delete('/{uuid}', "Api\Patient\PatientController@destroy");
    });

    Route::group( ['prefix'=>'dependants' ], function (){
        Route::get('/', "Api\Dependant\DependantController@index");
        Route::get('/{uuid}', "Api\Dependant\DependantController@show");
        Route::post('/', "Api\Dependant\DependantController@create");
        Route::post('/{uuid}', "Api\Dependant\DependantController@update");
        Route::delete('/{uuid}', "Api\Dependant\DependantController@destroy");
    });

    Route::group( ['prefix'=>'pharmacies' ], function (){

        Route::group( ['prefix'=>'analysis' ], function (){
            Route::get('/', "Api\Pharmacy\PharmacyAnalytic@index");
        });
        Route::get('/', "Api\Pharmacy\PharmacyController@index");
        Route::get('/{uuid}', "Api\Pharmacy\PharmacyController@show");
        Route::post('/', "Api\Pharmacy\PharmacyController@create");
        Route::post('/{uuid}', "Api\Pharmacy\PharmacyController@update");
        Route::delete('/{uuid}', "Api\Pharmacy\PharmacyController@destroy");
    });

    //USERS API ENDS HERE
    Route::group( ['prefix'=>'users' ], function (){

        Route::get('/{uuid}', "Api\Users\UserController@show");
        Route::get('/', "Api\Users\UserController@index");//->middleware('permission:view.users');
        Route::post('/', "Api\Users\UserController@create");//->middleware('permission:create.users');
        Route::put('/{uuid}', "Api\Users\UserController@update");//->middleware('permission:edit.users');
        Route::delete('/{uuid}', "Api\Users\UserController@destroy");//->middleware('permission:delete.users');
    });

    Route::group( ['prefix'=>'availability' ], function (){
        Route::get('/', "Api\Doctor\AvailabilityController@index");
        Route::get('/{uuid}', "Api\Doctor\AvailabilityController@show");
        Route::post('/', "Api\Doctor\AvailabilityController@create");
        Route::put('/', "Api\Doctor\AvailabilityController@update");
        Route::delete('/', "Api\Doctor\AvailabilityController@destroy");
        Route::get('/users/{uuid}', "Api\Doctor\AvailabilityController@get_by_user");
    });



    Route::group( ['prefix'=>'practices','middleware' => ['cors'] ], function (){ //

        Route::group( ['prefix'=>'dashboard' ], function (){
            Route::get('/', "Api\Practice\DashboardController@index");
            Route::post('/', "Api\Practice\DashboardController@create");
            Route::post('/{id}', "Api\Practice\DashboardController@update");
            Route::get('/reports', "Api\Practice\DashboardController@reports");
        });

        Route::group( ['prefix'=>'manufacturers' ], function (){
            Route::get('/', "Api\Practice\PracticeManufacturerController@index");
            Route::post('/', "Api\Practice\PracticeManufacturerController@create");
            Route::post('/{uuid}', "Api\Practice\PracticeManufacturerController@update");
            Route::delete('/{uuid}', "Api\Practice\PracticeManufacturerController@delete");
        });

        Route::group( ['prefix'=>'product_brands' ], function (){
            Route::get('/', "Api\Practice\Inventory\PracticeProductBrandController@index");
            Route::post('/', "Api\Practice\Inventory\PracticeProductBrandController@create");
            Route::post('/{uuid}', "Api\Practice\Inventory\PracticeProductBrandController@update");
            Route::delete('/{uuid}', "Api\Practice\Inventory\PracticeProductBrandController@delete");
        });

        Route::group( ['prefix'=>'medicine_category' ], function (){
            Route::get('/', "Api\Practice\PracticeProductCategoryController@index");
            Route::post('/', "Api\Practice\PracticeProductCategoryController@create");
            Route::post('/{uuid}', "Api\Practice\PracticeProductCategoryController@update");
            Route::delete('/{uuid}', "Api\Practice\PracticeProductCategoryController@delete");
        });

        Route::group( ['prefix'=>'roles' ], function (){
            Route::get('/', "Api\Practice\PracticeRoleController@index");
            Route::post('/', "Api\Practice\PracticeRoleController@create");
            Route::post('/{id}', "Api\Practice\PracticeRoleController@update");
            //Route::get('/{id}', "Api\Practice\PracticeRoleController@index");
            //Route::get('/practice/{uuid}', "Api\Practice\PracticeRoleController@practice");
            Route::delete('/{id}', "Api\Practice\PracticeRoleController@destroy");
        });

        Route::group( ['prefix'=>'users' ], function (){

            Route::group( ['prefix'=>'permissions' ], function (){
                Route::post('/', "Api\Practice\PracticeUserPermissionController@create");
                Route::get('/', "Api\Practice\PracticeUserPermissionController@index");
                Route::get('/{uuid}', "Api\Practice\PracticeUserPermissionController@show");
                Route::delete('/{id}', "Api\Practice\PracticeUserPermissionController@destroy");
            });

            // Route::group( ['prefix'=>'work_places' ], function (){
            //     Route::post('/', "Api\Practice\PracticeUserWorkPlaceController@create");
            //     Route::get('/', "Api\Practice\PracticeUserWorkPlaceController@index");
            //     Route::get('/{uuid}', "Api\Practice\PracticeUserWorkPlaceController@show");
            //     Route::delete('/{id}', "Api\Practice\PracticeUserWorkPlaceController@destroy");
            // });

            Route::post('/invite', "Api\Practice\PracticeUserController@invite");
            //Route::post('/master', "Api\Practice\PracticeUserController@master");
            Route::post('/', "Api\Practice\PracticeUserController@create");
            Route::get('/', "Api\Practice\PracticeUserController@index");
            Route::get('/{uuid}', "Api\Practice\PracticeUserController@show");
            //Route::get('/practice/{practice_uuid}', "Api\Practice\PracticeUserController@practice");
            Route::delete('/{uuid}', "Api\Practice\PracticeUserController@destroy");

        });

        // Route::group( ['prefix'=>'stores' ], function (){
        //     Route::post('/', "Api\Practice\StoresController@create");
        //     Route::get('/', "Api\Practice\StoresController@index");
        // });

        //Route::get('/{facility_id}/facilities', "Api\Practice\PracticeController@facilities");
        Route::get('/', "Api\Practice\PracticeController@index");//->middleware('permission:view.users');
        Route::post('/', "Api\Practice\PracticeController@create");//->middleware('permission:create.practice');
        Route::get('/{uuid}', "Api\Practice\PracticeController@show");//->middleware('permission:view.practice');
        //Route::get('/practice/{practice_uuid}', "Api\Practice\PracticeController@practice");//->middleware('permission:view.practice');
        //Route::get('/{practice_uuid}/{resource_type}', "Api\Practice\PracticeController@show_resource_based");//->middleware('permission:view.practice');
        Route::post('/{uuid}', "Api\Practice\PracticeController@update");//->middleware('permission:edit.practice');
        Route::delete('/{uuid}', "Api\Practice\PracticeController@delete");//->middleware('permission:delete.practice');

    });

    Route::group( ['prefix'=>'departments' ], function (){
        Route::post('/', "Api\Department\DepartmentController@create");
        Route::post('/{uuid}', "Api\Department\DepartmentController@update");
        Route::get('/', "Api\Department\DepartmentController@index");
        Route::get('/practice/{practice_uuid}', "Api\Department\DepartmentController@practice");
        Route::get('/{uuid}', "Api\Department\DepartmentController@show");
        Route::delete('/{id}', "Api\Department\DepartmentController@destroy");
    });

    Route::group( ['prefix'=>'medical' ], function (){

        Route::group( ['prefix'=>'registration' ], function (){
            //api for facility registration/login
            Route::put('/{uuid}', "Api\Doctor\MedicalRegistrationController@update");
            Route::post('/{uuid}', "Api\Doctor\MedicalRegistrationController@create");
        });

        Route::group( ['prefix'=>'assets' ], function (){
            Route::put('/{uuid}', "Api\Consultation\MedicalAssetsController@update");
            Route::delete('/{uuid}', "Api\Consultation\MedicalAssetsController@destroy");
            Route::post('/', "Api\Consultation\MedicalAssetsController@create");
            Route::post('/share', "Api\Consultation\MedicalAssetsController@share");
            Route::get('/', "Api\Consultation\MedicalAssetsController@index");
        });

    });

    Route::group( ['prefix'=>'education' ], function (){
        Route::put('/{uuid}', "Api\Doctor\EducationController@update");
        Route::post('/{uuid}', "Api\Doctor\EducationController@create");
    });

    //services apis
    Route::group( ['prefix'=>'services' ], function (){
        Route::get('/', "Api\Services\ServiceController@index");
        Route::post('/', "Api\Services\ServiceController@store");
    });

    Route::group( ['prefix'=>'consultations' ], function (){


        Route::group( ['prefix'=>'online' ], function (){
            Route::post('/', "Api\Consultation\OnlineConsultController@create");
            Route::post('/{uuid}', "Api\Consultation\OnlineConsultController@update");
        });

        Route::group( ['prefix'=>'offline' ], function (){
            Route::post('/', "Api\Consultation\OfflineConsultController@create");
            Route::post('/{uuid}', "Api\Consultation\OfflineConsultController@update");
        });

        Route::get('/', "Api\Consultation\ConsultationController@index");
        Route::get('/{uuid}', "Api\Consultation\ConsultationController@show");
        Route::delete('/{uuid}', "Api\Consultation\ConsultationController@destroy");
        Route::post('/{uuid}', "Api\Consultation\ConsultationController@update");
        Route::post('/', "Api\Consultation\ConsultationController@create");

//        Route::get('/', "Api\Consultation\ConsultationController@index");
//        Route::get('/{uuid}', "Api\Consultation\ConsultationController@show");
//        Route::get('/payments/{consult_uuid}', "Api\Consultation\ConsultationController@pay");
//        Route::get('/payments/show/{consult_uuid}', "Api\Consultation\ConsultationController@get_consult_payment");
//        Route::get('/payments/instructions/{consult_uuid}', "Api\Consultation\ConsultationController@payment_instruction");
//        Route::post('/payments/confirmation', "Api\Consultation\ConsultationController@payment_confirmation");
//        Route::post('/', "Api\Consultation\ConsultationController@store");
//        Route::put('/{uuid}', "Api\Consultation\ConsultationController@update");
//        Route::put('/symptoms/{uuid}', "Api\Consultation\PatientSymptomController@setConsultationSymptoms");
//        Route::delete('/{uuid}', "Api\Consultation\ConsultationController@destroy");
//        Route::get('/users/{uuid}', "Api\Consultation\ConsultationController@getByUser");
//        Route::group( ['prefix'=>'doctors' ], function (){
//            Route::post('/signatures', "Api\Consultation\ConsultationController@doctor_signature");
//        });

    });


    //symptoms apis
//    Route::group( ['prefix'=>'referrals' ], function (){
//        Route::post('/', "Api\Consultation\Prescription\ReferralController@create");
//        //symptoms apis
//        Route::group( ['prefix'=>'partners' ], function (){
//            //api for facility registration/login
//            Route::get('/', "Api\Referral\ReferalPartinerController@index");
//        });
//        Route::get('/consultation/{consult_uuid}', "Api\Consultation\Prescription\ReferralController@getConsultReferrals");
//    });

    //symptoms apis
//    Route::group( ['prefix'=>'sicknotes' ], function (){
//        Route::post('/', "Api\Consultation\Prescription\SicknoteController@create");
//        Route::get('/consultation/{consult_uuid}', "Api\Consultation\Prescription\SicknoteController@getConsultSicknotes");
//    });

    //medical records apis
    Route::group( ['prefix'=>'emr' ], function (){

        Route::group( ['prefix'=>'surgeries' ], function (){
            Route::get('/', "Api\Emr\Health\SurgeryController@index");
            Route::get('/{uuid}', "Api\Emr\Health\SurgeryController@show");
            Route::delete('/{uuid}', "Api\Emr\Health\SurgeryController@destroy");
            Route::post('/{uuid}', "Api\Emr\Health\SurgeryController@update");
            Route::post('/', "Api\Emr\Health\SurgeryController@create");
        });

        Route::group( ['prefix'=>'medications' ], function (){
            Route::get('/', "Api\Emr\Health\MedicationController@index");
            Route::get('/{uuid}', "Api\Emr\Health\MedicationController@show");
            Route::delete('/{uuid}', "Api\Emr\Health\MedicationController@destroy");
            Route::post('/{uuid}', "Api\Emr\Health\MedicationController@update");
            Route::post('/', "Api\Emr\Health\MedicationController@create");
        });

        Route::group( ['prefix'=>'conditions' ], function (){
            Route::get('/', "Api\Emr\Health\HealthConditionController@index");
            Route::get('/{uuid}', "Api\Emr\Health\HealthConditionController@show");
            Route::delete('/{uuid}', "Api\Emr\Health\HealthConditionController@destroy");
            Route::post('/{uuid}', "Api\Emr\Health\HealthConditionController@update");
            Route::post('/', "Api\Emr\Health\HealthConditionController@create");
        });

        Route::group( ['prefix'=>'allergies' ], function (){
            Route::get('/', "Api\Emr\Health\AllergyController@index");
            Route::get('/{uuid}', "Api\Emr\Health\AllergyController@show");
            Route::delete('/{uuid}', "Api\Emr\Health\AllergyController@destroy");
            Route::post('/{uuid}', "Api\Emr\Health\AllergyController@update");
            Route::post('/', "Api\Emr\Health\AllergyController@create");
        });

        Route::group( ['prefix'=>'complaints' ], function (){
            Route::get('/', "Api\Emr\Notes\ComplaintController@index");
            Route::get('/{uuid}', "Api\Emr\Notes\ComplaintController@show");
            Route::delete('/{uuid}', "Api\Emr\Notes\ComplaintController@destroy");
            Route::post('/{uuid}', "Api\Emr\Notes\ComplaintController@update");
            Route::post('/', "Api\Emr\Notes\ComplaintController@create");
        });

        Route::group( ['prefix'=>'diagnoses' ], function (){
            Route::get('/', "Api\Emr\Notes\DiagnoseController@index");
            Route::get('/{uuid}', "Api\Emr\Notes\DiagnoseController@show");
            Route::delete('/{uuid}', "Api\Emr\Notes\DiagnoseController@destroy");
            Route::post('/{uuid}', "Api\Emr\Notes\DiagnoseController@update");
            Route::post('/', "Api\Emr\Notes\DiagnoseController@create");
        });

        Route::group( ['prefix'=>'observations' ], function (){
            Route::get('/', "Api\Emr\Notes\ObservationController@index");
            Route::get('/{uuid}', "Api\Emr\Notes\ObservationController@show");
            Route::delete('/{uuid}', "Api\Emr\Notes\ObservationController@destroy");
            Route::post('/{uuid}', "Api\Emr\Notes\ObservationController@update");
            Route::post('/', "Api\Emr\Notes\ObservationController@create");
        });

        Route::group( ['prefix'=>'clinical_notes' ], function (){
            Route::get('/', "Api\Emr\Notes\ClinicalNotesController@index");
            Route::get('/{uuid}', "Api\Emr\Notes\ClinicalNotesController@show");
            Route::delete('/{uuid}', "Api\Emr\Notes\ClinicalNotesController@destroy");
            Route::post('/{uuid}', "Api\Emr\Notes\ClinicalNotesController@update");
            Route::post('/', "Api\Emr\Notes\ClinicalNotesController@create");
        });

        Route::group( ['prefix'=>'excuse_activities' ], function (){
            Route::get('/', "Api\Emr\Notes\ExecuseActivityController@index");
            Route::get('/{uuid}', "Api\Emr\Notes\ExecuseActivityController@show");
            Route::delete('/{uuid}', "Api\Emr\Notes\ExecuseActivityController@destroy");
            Route::post('/{uuid}', "Api\Emr\Notes\ExecuseActivityController@update");
            Route::post('/', "Api\Emr\Notes\ExecuseActivityController@create");
        });

        Route::group( ['prefix'=>'referrals' ], function (){
            Route::get('/', "Api\Emr\Notes\ReferralController@index");
            Route::get('/{uuid}', "Api\Emr\Notes\ReferralController@show");
            Route::delete('/{uuid}', "Api\Emr\Notes\ReferralController@destroy");
            Route::post('/{uuid}', "Api\Emr\Notes\ReferralController@update");
            Route::post('/', "Api\Emr\Notes\ReferralController@create");
        });

        Route::group( ['prefix'=>'sick_notes' ], function (){
            Route::get('/', "Api\Emr\Notes\SickNoteController@index");
            Route::get('/{uuid}', "Api\Emr\Notes\SickNoteController@show");
            Route::delete('/{uuid}', "Api\Emr\Notes\SickNoteController@destroy");
            Route::post('/{uuid}', "Api\Emr\Notes\SickNoteController@update");
            Route::post('/', "Api\Emr\Notes\SickNoteController@create");
        });

        Route::group( ['prefix'=>'lab_orders' ], function (){
            Route::get('/', "Api\Emr\Lab\LabOrderController@index");
            Route::get('/{uuid}', "Api\Emr\Lab\LabOrderController@show");
            Route::delete('/{uuid}', "Api\Emr\Lab\LabOrderController@destroy");
            Route::post('/{uuid}', "Api\Emr\Lab\LabOrderController@update");
            Route::post('/', "Api\Emr\Lab\LabOrderController@create");
        });

        Route::group( ['prefix'=>'test_panels' ], function (){
            Route::get('/', "Api\Emr\Lab\TestPanelController@index");
            Route::get('/{uuid}', "Api\Emr\Lab\TestPanelController@show");
            Route::delete('/{uuid}', "Api\Emr\Lab\TestPanelController@destroy");
            Route::post('/{uuid}', "Api\Emr\Lab\TestPanelController@update");
            Route::post('/', "Api\Emr\Lab\TestPanelController@create");
        });

        Route::group( ['prefix'=>'lab_templates' ], function (){
            Route::get('/', "Api\Emr\Lab\LabTemplateController@index");
            Route::get('/{uuid}', "Api\Emr\Lab\LabTemplateController@show");
            Route::delete('/{uuid}', "Api\Emr\Lab\LabTemplateController@destroy");
            Route::post('/{uuid}', "Api\Emr\Lab\LabTemplateController@update");
            Route::post('/', "Api\Emr\Lab\LabTemplateController@create");
        });

        Route::group( ['prefix'=>'vitals' ], function (){
            Route::get('/', "Api\Emr\Vitals\VitalSignController@index");
            Route::get('/{uuid}', "Api\Emr\Vitals\VitalSignController@show");
            Route::delete('/{uuid}', "Api\Emr\Vitals\VitalSignController@destroy");
            Route::post('/{uuid}', "Api\Emr\Vitals\VitalSignController@update");
            Route::post('/', "Api\Emr\Vitals\VitalSignController@create");
        });

        Route::group( ['prefix'=>'treatments' ], function (){

            Route::group( ['prefix'=>'procedures' ], function (){
                Route::get('/', "Api\Emr\Treatment\ProceedureController@index");
                Route::get('/{uuid}', "Api\Emr\Treatment\ProceedureController@show");
                Route::delete('/{uuid}', "Api\Emr\Treatment\ProceedureController@destroy");
                Route::post('/{uuid}', "Api\Emr\Treatment\ProceedureController@update");
                Route::post('/', "Api\Emr\Treatment\ProceedureController@create");
            });

            Route::group( ['prefix'=>'plans' ], function (){
                Route::get('/', "Api\Emr\Treatment\TreatmentPlanController@index");
                Route::get('/{uuid}', "Api\Emr\Treatment\TreatmentPlanController@show");
                Route::delete('/{uuid}', "Api\Emr\Treatment\TreatmentPlanController@destroy");
                Route::post('/{uuid}', "Api\Emr\Treatment\TreatmentPlanController@update");
                Route::post('/', "Api\Emr\Treatment\TreatmentPlanController@create");
            });

        });

        Route::group( ['prefix'=>'prescriptions' ], function (){

            Route::group( ['prefix'=>'assets' ], function (){
                Route::post('/', "Api\Emr\Prescription\AssetsController@create");
                Route::post('/{uuid}', "Api\Emr\Prescription\AssetsController@update");
                Route::get('/', "Api\Api\Emr\Prescription\AssetsController@index");
                Route::get('/{uuid}', "Api\Emr\Prescription\AssetsController@show");
                Route::delete('/{uuid}', "Api\Emr\Prescription\AssetsController@delete");
            });

            Route::post('/', "Api\Emr\Prescription\PrescriptionController@create");
            Route::post('/{uuid}', "Api\Emr\Prescription\PrescriptionController@update");
            Route::get('/', "Api\Emr\Prescription\PrescriptionController@index");
            Route::get('/{uuid}', "Api\Emr\Prescription\PrescriptionController@show");
            Route::delete('/{uuid}', "Api\Emr\Prescription\PrescriptionController@delete");

           //symptoms apis
        //    Route::group( ['prefix'=>'forms' ], function (){
        //        //api for facility registration/login
        //        Route::get('/', "Api\Consultation\Prescription\PrescriptionFormController@index");
        //    });

        //    Route::group( ['prefix'=>'frequencies' ], function (){
        //        //api for facility registration/login
        //        Route::get('/', "Api\Consultation\Prescription\PrescriptionFrequencyController@index");
        //    });

        //    Route::group( ['prefix'=>'routes' ], function (){
        //        //api for facility registration/login
        //        Route::get('/', "Api\Consultation\Prescription\PrescriptionRouteController@index");
        //    });

        });

    });

    Route::group( ['prefix'=>'accounting' ], function (){
        Route::group( ['prefix'=>'types' ], function (){
            Route::post('/', "Api\Product\Accounts\ProductAccountTypeController@create");
            Route::post('/{uuid}', "Api\Product\Accounts\ProductAccountTypeController@update");
            Route::get('/', "Api\Product\Accounts\ProductAccountTypeController@index");
            Route::get('/{uuid}', "Api\Product\Accounts\ProductAccountTypeController@show");
            Route::delete('/{uuid}', "Api\Product\Accounts\ProductAccountTypeController@destroy");
        });
        Route::group( ['prefix'=>'natures' ], function (){
            Route::post('/', "Api\Product\ProductAccountNatureController@create");
            Route::post('/{uuid}', "Api\Product\ProductAccountNatureController@update");
            Route::get('/', "Api\Product\ProductAccountNatureController@index");
            Route::get('/{uuid}', "Api\Product\ProductAccountNatureController@show");
            Route::delete('/{uuid}', "Api\Product\ProductAccountNatureController@destroy");
        });
        Route::group( ['prefix'=>'chart_of_accounts' ], function (){
            Route::get('/', "\App\Accounting\Http\Controllers\Api\Coa\ChartOfAccountsController@index");
            Route::post('/', "\App\Accounting\Http\Controllers\Api\Coa\ChartOfAccountsController@create");
            Route::post('/{uuid}', "\App\Accounting\Http\Controllers\Api\Coa\ChartOfAccountsController@update");
            Route::get('/{uuid}', "\App\Accounting\Http\Controllers\Api\Coa\ChartOfAccountsController@show");
        });
        //Accounting Reports
        Route::group( ['prefix'=>'accounts' ], function (){
            Route::get('/{uuid}', "\App\Accounting\Http\Controllers\Api\Accounts\AccountHolderController@show");
        });
        Route::group( ['prefix'=>'reports' ], function (){
            Route::get('/journals', "\App\Accounting\Http\Controllers\Api\Reports\ReportsController@journals");
            Route::get('/ledgers', "\App\Accounting\Http\Controllers\Api\Reports\ReportsController@ledgers");
            Route::get('/trail_balance', "\App\Accounting\Http\Controllers\Api\Reports\ReportsController@trail_balance");
            Route::get('/balance_sheet', "\App\Accounting\Http\Controllers\Api\Reports\ReportsController@balance_sheet");
        });
        Route::get('/initializations', "\App\Accounting\Http\Controllers\Api\Coa\ChartOfAccountsController@initials");
    });

    Route::group( ['prefix'=>'finance' ], function (){
        Route::group( ['prefix'=>'banks' ], function (){
            Route::group( ['prefix'=>'reconciliations' ], function (){
                Route::post('/', "\App\Finance\Http\Controllers\Api\Banking\BankReconcileController@create");
                Route::post('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BankReconcileController@update");
                Route::get('/', "\App\Finance\Http\Controllers\Api\Banking\BankReconcileController@index");
                Route::get('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BankReconcileController@show");
                Route::get('/{uuid}/{bank_uuid}', "\App\Finance\Http\Controllers\Api\Banking\BankReconcileController@show");
                Route::delete('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BankReconcileController@destroy");
            });
            Route::group( ['prefix'=>'transactions' ], function (){
                Route::post('/', "\App\Finance\Http\Controllers\Api\Banking\BankTransactionController@create");
                Route::post('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BankTransactionController@update");
                Route::get('/', "\App\Finance\Http\Controllers\Api\Banking\BankTransactionController@index");
                Route::get('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BankTransactionController@show");
                Route::delete('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BankTransactionController@destroy");
            });
            Route::group( ['prefix'=>'branches' ], function (){
                Route::post('/', "\App\Finance\Http\Controllers\Api\Banking\BanksBranchController@create");
                Route::post('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksBranchController@update");
                Route::get('/', "\App\Finance\Http\Controllers\Api\Banking\BanksBranchController@index");
                Route::get('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksBranchController@show");
                Route::delete('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksBranchController@destroy");
            });
            Route::group( ['prefix'=>'accounts' ], function (){
                Route::group( ['prefix'=>'types' ], function (){
                    Route::post('/', "\App\Finance\Http\Controllers\Api\Banking\AccountTypeController@create");
                    Route::post('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\AccountTypeController@update");
                    Route::get('/', "\App\Finance\Http\Controllers\Api\Banking\AccountTypeController@index");
                    Route::get('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\AccountTypeController@show");
                    Route::delete('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\AccountTypeController@delete");
                });
                Route::post('/', "\App\Finance\Http\Controllers\Api\Banking\BanksAccountsController@create");
                Route::post('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksAccountsController@update");
                Route::get('/', "\App\Finance\Http\Controllers\Api\Banking\BanksAccountsController@index");
                Route::get('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksAccountsController@show");
                Route::delete('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksAccountsController@destroy");
            });
            Route::post('/', "\App\Finance\Http\Controllers\Api\Banking\BanksController@create");
            Route::post('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksController@update");
            Route::get('/', "\App\Finance\Http\Controllers\Api\Banking\BanksController@index");
            Route::get('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksController@show");
            Route::delete('/{uuid}', "\App\Finance\Http\Controllers\Api\Banking\BanksController@destroy");
        });
    });

    // Route::group( ['prefix'=>'supplier' ], function (){

    //     Route::group( ['prefix'=>'vendors' ], function (){
    //         Route::get('/', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@index");
    //         Route::post('/', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@create");
    //         Route::post('/{uuid}', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@update");
    //         Route::get('/{uuid}', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@show");
    //         Route::delete('/{uuid}', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@delete");
    //     });
        
    // });

    Route::group( ['prefix'=>'customers' ], function (){

        Route::group( ['prefix'=>'estimates' ], function (){
            Route::get('/', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@index");
            Route::post('/', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@create");
            Route::post('/{uuid}', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@update");
            Route::get('/{uuid}', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@show");
            Route::delete('/{uuid}', "\App\Customer\Http\Controllers\Api\Estimate\EstimateController@delete");
        });

        Route::group( ['prefix'=>'debtors' ], function (){
            Route::get('/', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@index");
            Route::post('/', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@create");
            Route::post('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@update");
            Route::get('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@show");
            Route::delete('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@delete");
        });

        Route::group( ['prefix'=>'terms' ], function (){
            Route::get('/', "\App\Customer\Http\Controllers\Api\Customer\TermsController@index");
            Route::post('/', "\App\Customer\Http\Controllers\Api\Customer\TermsController@create");
            Route::post('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\TermsController@update");
            Route::get('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\TermsController@show");
            Route::delete('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\TermsController@delete");
        });
        Route::get('/dashboard', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@dashboard");

        // Route::get('/', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@index");
        // Route::post('/', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@create");
        // Route::post('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@update");
        // Route::get('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@show");
        // Route::delete('/{uuid}', "\App\Customer\Http\Controllers\Api\Customer\CustomerController@delete");
    });

    Route::group( ['prefix'=>'suppliers' ], function (){
        // Route::get('/', "Api\Supplier\SupplierController@index");
        // Route::get('/{uuid}', "Api\Supplier\SupplierController@show");
        // Route::post('/', "Api\Supplier\SupplierController@create");
        // Route::post('/{uuid}', "Api\Supplier\SupplierController@update");
        // Route::post('/upload', "Api\Supplier\SupplierController@upload");
        // Route::delete('/{uuid}', "Api\Supplier\SupplierController@delete");
        Route::group( ['prefix'=>'purchases' ], function (){

            Route::group( ['prefix'=>'orders' ], function (){

                Route::group( ['prefix'=>'assets' ], function (){
                    Route::get('/', "\App\Supplier\Http\Controllers\Api\Purchase\PoAssetControler@index");
                    Route::post('/', "\App\Supplier\Http\Controllers\Api\Purchase\PoAssetControler@create");
                    Route::post('/{uuid}', "\App\Supplier\Http\Controllers\Api\Purchase\PoAssetControler@update");
                    Route::get('/{uuid}', "\App\Supplier\Http\Controllers\Api\Purchase\PoAssetControler@show");
                    Route::delete('/{uuid}', "\App\Supplier\Http\Controllers\Api\Purchase\PoAssetControler@delete");
                });

                Route::get('/', "\App\Supplier\Http\Controllers\Api\Purchase\PurchaseOrderController@index");
                Route::post('/', "\App\Supplier\Http\Controllers\Api\Purchase\PurchaseOrderController@create");
                Route::post('/{uuid}', "\App\Supplier\Http\Controllers\Api\Purchase\PurchaseOrderController@update");
                Route::get('/{uuid}', "\App\Supplier\Http\Controllers\Api\Purchase\PurchaseOrderController@show");
            });

        });

        Route::group( ['prefix'=>'bills' ], function (){
            Route::get('/', "\App\Supplier\Http\Controllers\Api\Bills\BillController@index");
            Route::post('/', "\App\Supplier\Http\Controllers\Api\Bills\BillController@create");
            Route::get('/{uuid}', "\App\Supplier\Http\Controllers\Api\Bills\BillController@show");
        });
        //
        Route::group( ['prefix'=>'vendors' ], function (){
            Route::get('/', "\App\Supplier\Http\Controllers\Api\Vendor\VendorController@index");
            Route::post('/', "\App\Supplier\Http\Controllers\Api\Vendor\VendorController@create");
            Route::post('/{uuid}', "\App\Supplier\Http\Controllers\Api\Vendor\VendorController@update");
            Route::get('/{uuid}', "\App\Supplier\Http\Controllers\Api\Vendor\VendorController@show");
            Route::delete('/{uuid}', "\App\Supplier\Http\Controllers\Api\Vendor\VendorController@destroy");
        });
        //companies
        Route::group( ['prefix'=>'companies' ], function (){
            Route::get('/', "\App\Supplier\Http\Controllers\Api\Vendor\CompanyController@index");
            Route::post('/', "\App\Supplier\Http\Controllers\Api\Vendor\CompanyController@create");
            Route::get('/{uuid}', "\App\Supplier\Http\Controllers\Api\Vendor\CompanyController@show");
        });

        //companies
        Route::group( ['prefix'=>'terms' ], function (){
            Route::get('/', "\App\Supplier\Http\Controllers\Api\Vendor\TermsController@index");
            Route::post('/', "\App\Supplier\Http\Controllers\Api\Vendor\TermsController@create");
            Route::get('/{uuid}', "\App\Supplier\Http\Controllers\Api\Vendor\TermsController@show");
        });

    });

    //Products///COLLINS HERE
    Route::group( ['prefix'=>'products' ], function (){

        Route::group( ['prefix'=>'stores' ], function (){
            Route::post('/', "Api\Product\Stores\ProductStoreController@create");
            Route::post('/{uuid}', "Api\Product\Stores\ProductStoreController@update");
            Route::get('/', "Api\Product\Stores\ProductStoreController@index");
            Route::get('/practice/{practice_id}/{store_type}', "Api\Product\Stores\ProductStoreController@index");
        });

        Route::group( ['prefix'=>'supply'], function (){
            Route::get('/', "Api\Product\Supply\ProductSupplyController@index");
            Route::get('/{practice_id}', "Api\Product\Supply\ProductSupplyController@index");
            Route::post('/', "Api\Product\Supply\ProductSupplyController@create");
            Route::post('/{uuid}', "Api\Product\Supply\ProductSupplyController@update");

            Route::get('/gon/{practice_id}', "Api\Product\Supply\ProductSupplyController@index_gon");
            Route::post('/gon/{uuid}', "Api\Product\Supply\ProductSupplyController@update_gon");
        });

        Route::group( ['prefix'=>'notifications'], function (){
            Route::get('/{practice_uuid}/{type}', "Api\Product\ProductNotificationController@index");
            Route::post('/', "Api\Product\ProductNotificationController@create");
        });

        Route::group( ['prefix'=>'reports'], function (){
            Route::get('/', "Api\Product\ReportController@index");
            //Route::get('/{practice_id}', "Api\Product\ReportController@index");
            Route::post('/', "Api\Product\ReportController@generate");
        });

        Route::group( ['prefix'=>'requisitions'], function (){
            Route::post('/', "Api\Product\ProductStockRequistionController@create");
            Route::post('/{uuid}', "Api\Product\ProductStockRequistionController@update");
            Route::get('/{practice_id}', "Api\Product\ProductStockRequistionController@index");
            Route::get('/{practice_id}/{department_id}/{store_id}/{sub_store_id}', "Api\Product\ProductStockRequistionController@index");
        });

        Route::group( ['prefix'=>'stocks'], function (){
            //
            Route::post('/', "Api\Product\Stocks\StockController@store");
            Route::post('/barcode', "Api\Product\Stocks\StockController@barcode");
            Route::post('/reports', "Api\Product\Stocks\StockController@reports");
            Route::post('/taking', "Api\Product\Stocks\StockController@stock_taking");
            Route::post('/{uuid}', "Api\Product\Stocks\StockController@update");
            Route::get('/practice/{practice_uuid}/{stock_state}', "Api\Product\Stocks\StockController@index");
            Route::get('/{uuid}', "Api\Product\Stocks\StockController@show");
            Route::delete('/{id}', "Api\Product\Stocks\StockController@destroy");
            Route::get('/', "Api\Product\Stocks\StockController@index");
        });

        Route::group( ['prefix'=>'types'], function (){
            Route::post('/', "Api\Product\ProductTypeController@store");
            Route::post('/{uuid}', "Api\Product\ProductTypeController@update");
            Route::get('/practice/{practice_uuid}', "Api\Product\ProductTypeController@practice");
            Route::get('/{uuid}', "Api\Product\ProductTypeController@show");
            Route::delete('/{id}', "Api\Product\ProductTypeController@destroy");
            Route::get('/', "Api\Product\ProductTypeController@index");
        });

        Route::group( ['prefix'=>'categories' ], function (){
            Route::group( ['prefix'=>'subcategory' ], function (){
                Route::get('/', "Api\Product\ProductSubCategoryController@index");
                Route::get('/practice/{practice_uuid}', "Api\Product\ProductSubCategoryController@index");
                Route::get('/{uuid}', "Api\Product\ProductSubCategoryController@show");
                Route::post('/', "Api\Product\ProductSubCategoryController@create");
                Route::delete('/{uuid}', "Api\Product\ProductSubCategoryController@destroy");
                Route::post('/{uuid}', "Api\Product\ProductSubCategoryController@update");
            });

            Route::group( ['prefix'=>'orders' ], function (){
                Route::get('/', "Api\Product\ProductOrderCategoryController@index");
                Route::get('/practice/{practice_uuid}', "Api\Product\ProductOrderCategoryController@index");
                Route::get('/{uuid}', "Api\Product\ProductOrderCategoryController@show");
                Route::post('/', "Api\Product\ProductOrderCategoryController@create");
                Route::delete('/{uuid}', "Api\Product\ProductOrderCategoryController@destroy");
                Route::post('/{uuid}', "Api\Product\ProductOrderCategoryController@update");
            });

            Route::get('/', "Api\Product\ProductCategoryController@index");
            Route::get('/{uuid}', "Api\Product\ProductCategoryController@show");
            Route::post('/', "Api\Product\ProductCategoryController@create");
            Route::delete('/{uuid}', "Api\Product\ProductCategoryController@destroy");
            Route::post('/{uuid}', "Api\Product\ProductCategoryController@update");
            Route::get('/practice/{practice_uuid}', "Api\Product\ProductCategoryController@practice");
        });

        Route::group( ['prefix'=>'items' ], function (){
            Route::post('/', "Api\Product\ProductController@store");
            Route::post('/upload', "Api\Product\ProductController@upload");
            Route::get('/all_items', "Api\Product\ProductItemController@all_list");
            Route::get('/', "Api\Product\ProductItemController@index");
            Route::post('/{uuid}', "Api\Product\ProductItemController@update");
            Route::get('/{uuid}', "Api\Product\ProductItemController@show");
            Route::delete('/{uuid}', "Api\Product\ProductItemController@destroy");
        });

        Route::group( ['prefix'=>'payment_methods' ], function (){
            Route::get('/', "Api\Product\ProductPaymentMethodController@index");
            Route::get('/{id}', "Api\Product\ProductPaymentMethodController@show");
            Route::post('/', "Api\Product\ProductPaymentMethodController@create");
            Route::delete('/{id}', "Api\Product\ProductPaymentMethodController@destroy");
            Route::post('/{uuid}', "Api\Product\ProductPaymentMethodController@update");
        });

        Route::group( ['prefix'=>'taxations'], function (){
            Route::get('/', "Api\Product\TaxationController@index");
            Route::post('/', "Api\Product\TaxationController@create");
            Route::post('/{uuid}', "Api\Product\TaxationController@update");
            Route::delete('/{uuid}', "Api\Product\TaxationController@destroy");
            // Route::get('/', "Api\Product\ProductSalesChargeController@index");
            // Route::get('/{practice_uuid}', "Api\Product\ProductSalesChargeController@index");
            // Route::post('/', "Api\Product\ProductSalesChargeController@create");
            // Route::post('/{uuid}', "Api\Product\ProductSalesChargeController@update");
            // Route::get('/practice/{practice_uuid}', "Api\Product\ProductSalesChargeController@practice");
            // Route::delete('/{uuid}', "Api\Product\ProductSalesChargeController@destroy");
        });

        Route::group( ['prefix'=>'purchases' ], function (){

            Route::group( ['prefix'=>'po' ], function (){
                Route::post('/', "Api\Product\Purchase\POController@create");
                Route::post('/grn', "Api\Product\Purchase\POController@grn");
                Route::post('/upload', "Api\Product\Purchase\POController@upload");
                Route::get('/practice/{practice_uuid}', "Api\Product\Purchase\POController@practice");
                Route::get('/facility/{facility_id}', "Api\Product\Purchase\POController@facility");
                Route::get('/{uuid}', "Api\Product\Purchase\POController@show");
                Route::get('/{uuid}/facility/{practice_uuid}', "Api\Product\Purchase\POController@show");
                Route::get('/', "Api\Product\Purchase\POController@index");
                Route::get('/{uuid}/practice/{practice_uuid}', "Api\Product\Purchase\POController@index");
                Route::delete('/{id}', "Api\Product\Purchase\POController@destroy");
            });

            Route::get('/', "Api\Product\Purchase\ProductPurchaseController@index");
            Route::get('/facility/{facility_id}', "Api\Product\Purchase\ProductPurchaseController@index");
            Route::get('/{id}', "Api\Product\Purchase\ProductPurchaseController@show");
            Route::get('/initials', "Api\Product\Purchase\ProductPurchaseController@initials");
            Route::post('/', "Api\Product\Purchase\ProductPurchaseController@store");
            Route::delete('/{id}', "Api\Product\Purchase\ProductPurchaseController@destroy");
            Route::post('/{uuid}', "Api\Product\Purchase\ProductPurchaseController@update");
        });

        Route::group( ['prefix'=>'brands' ], function (){

            Route::group( ['prefix'=>'sectors' ], function (){
                Route::get('/', "Api\Product\ProductBrandSectorController@index");
                Route::get('/practice/{practice_uuid}', "Api\Product\ProductBrandSectorController@index");
                Route::get('/{id}', "Api\Product\ProductBrandSectorController@show");
                Route::post('/', "Api\Product\ProductBrandSectorController@create");
                Route::delete('/{id}', "Api\Product\ProductBrandSectorController@destroy");
                Route::post('/{uuid}', "Api\Product\ProductBrandSectorController@update");
            });

            Route::get('/', "Api\Product\ProductBrandController@index");
            Route::get('/practice/{practice_id}', "Api\Product\ProductBrandController@index");
            Route::get('/{id}', "Api\Product\ProductBrandController@show");
            Route::post('/', "Api\Product\ProductBrandController@store");
            Route::delete('/{id}', "Api\Product\ProductBrandController@destroy");
            Route::post('/{uuid}', "Api\Product\ProductBrandController@update");
        });

        Route::group( ['prefix'=>'currencies' ], function (){
            Route::get('/', "Api\Product\ProductCurrencyController@index");
            Route::get('/practice/{practice_uuid}', "Api\Product\ProductCurrencyController@index");
            Route::get('/{id}', "Api\Product\ProductCurrencyController@show");
            Route::post('/', "Api\Product\ProductCurrencyController@create");
            Route::delete('/{id}', "Api\Product\ProductCurrencyController@destroy");
            Route::post('/{id}', "Api\Product\ProductCurrencyController@update");
        });

        Route::group( ['prefix'=>'units' ], function (){
            Route::get('/', "Api\Product\ProductUnitController@index");
            Route::get('/practice/{practice_uuid}', "Api\Product\ProductUnitController@index");
            Route::get('/{id}', "Api\Product\ProductUnitController@show");
            Route::post('/', "Api\Product\ProductUnitController@create");
            Route::delete('/{id}', "Api\Product\ProductUnitController@destroy");
            Route::post('/{uuid}', "Api\Product\ProductUnitController@update");
        });

        Route::group( ['prefix'=>'generics'], function (){
            Route::post('/', "Api\Product\ProductGenericController@create");
            Route::post('/{uuid}', "Api\Product\ProductGenericController@update");
            Route::get('/practice/{practice_uuid}', "Api\Product\ProductGenericController@practice");
            Route::get('/{uuid}', "Api\Product\ProductGenericController@show");
            Route::delete('/{id}', "Api\Product\ProductGenericController@destroy");
        });

        Route::group( ['prefix'=>'formulations'], function (){
            Route::get('/', "Api\Product\Formulation\FormulationController@index");
            Route::post('/', "Api\Product\Formulation\FormulationController@store");
            Route::post('/{uuid}', "Api\Product\Formulation\FormulationController@update");
            Route::get('/{uuid}', "Api\Product\Formulation\FormulationController@show");
            Route::delete('/{id}', "Api\Product\Formulation\FormulationController@destroy");
        });

        Route::group( ['prefix'=>'routes' ], function (){
            Route::get('/', "Api\Product\Route\RouteController@index");
            Route::post('/', "Api\Product\Route\RouteController@store");
            Route::post('/{uuid}', "Api\Product\Route\RouteController@update");
            Route::get('/{uuid}', "Api\Product\Route\RouteController@show");
            Route::delete('/', "Api\Product\Route\RouteController@destroy");
        });

        Route::group( ['prefix'=>'vaccines' ], function (){
            Route::get('/', "Api\Product\Vaccine\VaccineController@index");
            Route::post('/', "Api\Product\Vaccine\VaccineController@store");
            Route::post('/{uuid}', "Api\Product\Vaccine\VaccineController@update");
            Route::get('/{uuid}', "Api\Product\Vaccine\VaccineController@show");
            Route::delete('/', "Api\Product\Vaccine\VaccineController@destroy");
        });

        //Route::get('/', "Api\Product\ProductController@index");
        //Route::get('/{id}', "Api\Product\ProductController@show");
        Route::get('/attributes', "Api\Product\ProductController@attributes");
        Route::post('/', "Api\Product\ProductController@store");
        //Route::delete('/{id}', "Api\Product\ProductController@destroy");
        //Route::post('/{id}', "Api\Product\ProductController@update");
        Route::post('/', "Api\Product\ProductController@create");
        Route::post('/{uuid}', "Api\Product\ProductController@update");
        Route::post('/upload', "Api\Product\ProductController@upload");
        // Route::get('/practice/{practice_uuid}', "Api\Product\ProductController@practice");
        Route::get('/practice/{practice_uuid}', "Api\Product\ProductController@practice");
        Route::get('/facility/{facility_uuid}', "Api\Product\ProductController@facility");
        Route::get('/{uuid}', "Api\Product\ProductController@show");
        Route::get('/{uuid}/facility/{practice_uuid}', "Api\Product\ProductController@show");
        Route::get('/', "Api\Product\ProductController@index");
        Route::get('/{facility_id}/{barcode}', "Api\Product\ProductController@barcode");
        Route::get('/{uuid}/practice/{practice_uuid}', "Api\Product\ProductController@index");
        Route::delete('/{id}', "Api\Product\ProductController@destroy");
        
    });

    Route::group( ['prefix'=>'manufacturers' ], function (){
        Route::get('/', "Api\Manufacturer\ManufacturerController@index");
        Route::get('/{id}', "Api\Manufacturer\ManufacturerController@show");
        Route::post('/', "Api\Manufacturer\ManufacturerController@store");
        Route::delete('/{id}', "Api\Manufacturer\ManufacturerController@destroy");
        Route::post('/{id}', "Api\Manufacturer\ManufacturerController@update");
    });

    Route::group( ['prefix'=>'uploads' ], function (){
        Route::post('/', "Api\Upload\UploadController@uploads");
        Route::post('/create', "Api\Upload\UploadController@create");
    });

    //SEARCH ROUTE HERE
    Route::post('/search/{type}', "Api\Search\SearchController@search");
    
    
});


//Login
//POST: https://afyatele.com/api/oauth/login

//Get Categories List
//GET:  https://afyatele.com/api/products/categories/facility/{facility_id}

//Get Products in a category
//GET:  https://afyatele.com/api/products/categories/{category_id}

//Get a Single product
//GET:  https://afyatele.com/api/products/{product_id}

//Scanned Barcode DB Search
//POST:  https://afyatele.com/api/products/{facility_id}/{barcode}
//Scanned Barcode DB Search
//POST:  https://afyatele.com/api/products/stocks/barcode

//Get Facility & Branches
//GET:  https://afyatele.com/api/practices/{facility_id}/facilities

//Products & their Stock Levels in a facility
//GET:  https://afyatele.com/api/practices/{facility_id}/stocks




//Place Order
//POST: https://afyatele.com/api/products/purchases/po
//PARAMS:
//facility_id: 123456,
//items: [{"item_id":"1","qty":"200"},{"item_id":"2","qty":"300"}] - Stringfied

//Get a single PO
//GET: https://afyatele.com/api/products/purchases/po/{po_id}

//Get List of PO placed by a facility
//GET: https://afyatele.com/api/products/purchases/po/facility/{facility_id}

//Place Order Initials
//GET: https://afyatele.com/api/products/purchases/initials/{facility_id}


