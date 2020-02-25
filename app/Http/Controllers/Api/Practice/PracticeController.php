<?php

namespace App\Http\Controllers\Api\Practice;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\helpers\HelperFunctions;
use App\Models\Doctor\Doctor;
use App\Models\Localization\Country;
use App\Models\Patient\Patient;
use App\Models\Pharmacy\Pharmacy;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeAsset;
use App\Models\Practice\PracticeProductItem;
use App\Models\Practice\PracticeTransactionDocument;
use App\Models\Practice\PracticeUsers;
use App\Models\Practice\Settings\PracticeFinancialSetting;
use App\Models\Practice\Taxation\PracticeTax;
use App\Models\Practice\TransactionDocument;
use App\Models\Product\Purchase\ProductPurchase;
use App\Models\Users\User;
use App\Repositories\Doctor\DoctorRepository;
use App\Repositories\Localization\LocalizationRepository;
use App\Repositories\Patient\PatientRepository;
use App\Repositories\Pharmacy\PharmacyRepository;
use App\Repositories\Practice\PracticeAssetRepository;
use App\Repositories\Practice\PracticeRepository;
use App\Repositories\Practice\PracticeUserRepository;
use App\Repositories\Product\ProductReposity;
use App\Repositories\User\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Traits\ActivationTrait;
use App\Transformers\User\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\Product\ProductType;
use App\Models\Hospital\Hospital;
use App\Models\Module\Module;
use App\Models\Practice\PracticeFinanceSetting;
use App\Models\Practice\PracticeUser;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;

class PracticeController extends Controller
{
    use ActivationTrait;
    protected $practice;
    protected $practiceUser;
    protected $doctor;
    protected $patient;
    protected $response_type;
    protected $helper;
    protected $user;
    protected $role;
    protected $practice_asset;
    protected $pharmacy;
    protected $accountsCoa;
    protected $suppliers;
    protected $customers;
    protected $countries;
    protected $financialYears;
    protected $practiceTax;
    protected $practiceTransactionDocument;
    protected $chartOfAccounts;
    protected $accountTypes;
    protected $accountingVouchers;
    protected $transactionDocuments;
    protected $ASSETS;
    protected $EQUITY;
    protected $LIABILITY;
    protected $AC_OPENING_BALANCE_EQUITY_CODE;
    protected $TRANS_NAME_OPEN_BALANCE;
    protected $AC_SALES_SERVICE_TAX_PAYABLE_CODE;

    public function __construct(Practice $practice)
    {
        $this->practice = new PracticeRepository($practice);
        $this->practice_asset = new PracticeAssetRepository(new PracticeAsset());
        $this->role = new RoleRepository(new Role());
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        $this->user = new UserRepository(new User());
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->customers = new CustomerRepository( new Customer() );
        $this->practiceUser = new PracticeRepository(new PracticeUser());
        $this->countries = new LocalizationRepository(new Country());
        $this->financialYears = new PracticeRepository( new PracticeFinancialSetting() );
        $this->practiceTax = new PracticeRepository( new PracticeTax() );
        $this->practiceTransactionDocument = new PracticeRepository( new PracticeTransactionDocument() );
        $this->chartOfAccounts = new AccountingRepository( new AccountChartAccount() );
        $this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountingVouchers = new AccountingRepository(new AccountsVoucher());
        $this->ASSETS = AccountsCoa::ASSETS;
        $this->EQUITY = AccountsCoa::EQUITY;
        $this->LIABILITY = AccountsCoa::LIABILITY;
        $this->AC_OPENING_BALANCE_EQUITY_CODE = AccountsCoa::AC_OPENING_BALANCE_EQUITY_CODE;
        $this->TRANS_NAME_OPEN_BALANCE = AccountsCoa::TRANS_NAME_OPEN_BALANCE;
        $this->AC_SALES_SERVICE_TAX_PAYABLE_CODE = AccountsCoa::AC_SALES_SERVICE_TAX_PAYABLE_CODE;
        $this->transactionDocuments = new PracticeRepository( new TransactionDocument() );

    }

    public function index(Request $request){

        $http_resp = $this->response_type['200'];
        $results = array();
        $company = $this->practice->find($request->user()->company_id);
        $user = $this->user->find($request->user()->id);
        $parentPractice = $this->practice->findParent($company);
        $facilities = $parentPractice->practices()->paginate(10);
        $paged_data = $this->helper->paginator($facilities);
        foreach( $facilities as $facility ){
            $practiceUser = $this->practiceUser->findByUserAndCompany($user,$facility);
            if($practiceUser && $practiceUser->getCanAccessCompany()){
                array_push($paged_data['data'],$this->practice->transform_($facility));
            }
        }
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);

    }



    public function delete($uuid){
        $http_resp = $this->response_type['200'];
        $this->practice->delete($uuid);
        $http_resp['description'] = "Company successful deleted";
        return response()->json($http_resp);
    }

    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rules = [
            'name' => 'required',
            'address' => 'required',
            //'registration_number' => 'required|unique:practices',
            'email' => 'required|unique:practices',
            'mobile' => 'required|unique:practices',
            //'country' => 'required',
            'city' => 'required',
            //'propriator_title' => 'required',
            'website' => 'required',
            'postal_code' => 'sometimes|required',
            'business_type' => 'sometimes|required',
            //'industry' => 'sometimes|required',
        ];
        $validation = Validator::make($request->all(),$rules);
        if ($validation->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }


//        if ( ($request->website != "") && (!$this->helper->is_website_exist($request->website))){
//            $http_resp = $this->response_type['422'];
//            $http_resp['errors'] = ['Invalid website url'];
//            return response()->json($http_resp,422);
//        }

        /*
            Steps in Setting up a Company
            1. Create a company,
            2.  And Attach Company Financial Settings,
            3. Setup charts of accounts for a company
            4. Setup Payment methods for a company
            5. Setup Company Default supplier Terms
            6. Setup Company Default customer Terms
            7. If Logo is not provided let parent logo be default
            8. Set Default Government Taxation Rates
            9. Set Company Supplier Dashboard Widgets
            10. Configure Company Sales Tax Accounts
            11. If finance year begin date is not provided, default begin date should be 1st January of current Year, and END date to be 31st Dec of Current Year
        */
        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->beginTransaction();
        try{

            $current_company = $this->practice->find($request->user()->company_id);
            $the_enterprise = $this->practice->findParent($current_company);
            $head_quarter = $this->practice->findHq($current_company);

            $inputs = $request->all();
            $new_company = $the_enterprise->practices()->create($inputs);

            //Set Company Chart of Accounts
            $this->chartOfAccounts->setCompanyChartOfAccount($new_company);//This function Initializes Default Company Chart of Accounts
            //Set Company Statutory
            $new_company->statutories()->create($inputs);
            //Set Company Address
            $new_company->addresses()->create($inputs);
            //Set Customer Zone
            $new_company->customerZone()->create(['accounting_zone'=>true,'invoice_and_quotes'=>true]);
            //Set company Financial Years
            $fin_yr_start = date('Y-m-d', strtotime('first day of january this year'));
            $fin_yr_end = date('Y-m-d', strtotime('last day of december this year'));
            $new_company->financialSettings()->create(['financial_year_start'=>$fin_yr_start,'financial_year_end'=>$fin_yr_end,'current_accounting_period'=>true]);
            //Set company General Settings
            $new_company->generalSettings()->create(['ageing_monthly'=>true]);
            //Set Customer Supplier Settings
            $new_company->customerSupplierSettings()->create(['warn_dup_reference'=>true]);
            //Set Company Inventory Settings
            $new_company->inventorySettings()->create(['warn_item_qty_zero'=>true]);
            //Set Transactional Documents
            $trans_documents = $this->transactionDocuments->all();
            foreach ($trans_documents as $trans_document){
                $inp = $trans_document->toArray();
                $inp['practice_id'] = $new_company->id;
                $practice_docs = $trans_document->practiceTransactionDocuments()->create($inp);
            }

            $vat_system = $the_enterprise->taxation()->get()->first();
            if($vat_system){
                $salesTax = $this->chartOfAccounts->findCompanyMainCoaByDefaultCode($new_company,$this->AC_SALES_SERVICE_TAX_PAYABLE_CODE);
                $taxations = $vat_system->vatTypes()->get();
                foreach( $taxations as $taxation ){
                    //Attach to branch
                    //$practice_taxation = $taxation->practice_taxation()->create(['practice_id'=>$facility->id]);
                    //Use Branch Taxation to create Tax Chart of Account
                    $sub_ac_inputs['name'] = $taxation->name;
                    $practice_vat_type = $taxation->practiceVatTypes()->create(['practice_id'=>$new_company->id]);
                    $tax_sub_accounts = $this->chartOfAccounts->create_sub_chart_of_account($new_company,$salesTax,$sub_ac_inputs,$practice_vat_type);
                }
            }
            //Set Company Default Payment Methods
            $this->accountsCoa->company_payment_initialization($new_company);
            //Set Company Default Supplier Terms
            $this->suppliers->company_terms_initializations($new_company);
            //Set Company Default Customer Terms
            $this->customers->company_terms_initialization($new_company);

            //Newly created company logo is inherited from Headquarter Office
            $logo_assets = $head_quarter->assets()->where('asset_type','logo')->get()->first();
            if($logo_assets){
                $new_company->assets()->create($this->practice->transformAsset($logo_assets));
            }

            //Set Access to newly created company for the current logged in user
            $current_user = $this->user->find($request->user()->id);//Logged in User
            $current_user_company = $current_user->practiceUsers()->get()->first(); //Logged in User Company Profile
            $new_user_input = $current_user->toArray();
            $new_user_input['company_id'] = $new_company->id;
            $new_user = $this->user->storeRecord($new_user_input);
            $new_company_inputs = $current_user_company->toArray();
            $new_company_inputs['practice_id'] = $new_company->id;
            $new_company_inputs['user_id'] = $new_user->id;
            $practice_user_obj = $this->practiceUser->create($new_company_inputs);

        }catch (\Exception $e){
            //$this->helper->delete_file($path_to_store);
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        DB::connection(Module::MYSQL_SUPPLIERS_DB_CONN)->commit();
        DB::connection(Module::MYSQL_CUSTOMER_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){
        Log::info($request);
        $http_resp = $this->response_type['200'];
        $practice = $this->practice->findByUuid($uuid);
        $rules = [];
        if($request->has('section')){
            switch ($request->section){
                case "Company Details":
                    $rules = [
                        'address' => 'sometimes|required',
                        'city' => 'sometimes|required',
                        'name' => 'sometimes|required',
                        'status' => 'sometimes|required',
                        'region' => 'sometimes|required',
                        'legal_name' => 'sometimes|required',
                        'phone' => 'sometimes|required',
                        'mobile' => 'sometimes|required',
                        'fax' => 'sometimes|required',
                        'email' => 'sometimes|required',
                        'postal_code' => 'required',
                        'zip_code' => 'required',
                        'country_id' => 'required',
                    ];
                    break;
                case "Financial Years":
                    $rules = [
                        'financial_year_start' => 'required',
                        'financial_year_end' => 'required',
                        'current_accounting_period' => 'required',
                    ];
                    break;
                case "Branding":
                    $rules = [
                        'file' => 'required',
                    ];
                    break;
            }
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()){
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }else{
            $rules = [
                'address' => 'sometimes|required',
                'city' => 'sometimes|required',
                'country' => 'sometimes|required',
                'name' => 'sometimes|required',
                'status' => 'sometimes|required',
                'file' => 'sometimes|required|max:500000',
                'propriator_title' => 'sometimes|required',
                'website' => 'sometimes|required',
                'postal_code' => 'sometimes|required',
                'business_type' => 'sometimes|required',
                'industry' => 'sometimes|required',
                'registration_number' => 'sometimes|required|unique:practices,registration_number,'.$practice->id,
                'email' => 'sometimes|required|unique:practices,email,'.$practice->id,
                'mobile' => 'sometimes|required|unique:practices,mobile,'.$practice->id,
            ];
            $validation = Validator::make($request->all(),$rules);
            if ($validation->fails()){
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
                return response()->json($http_resp,422);
            }
        }

        DB::connection(Module::MYSQL_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            if($request->has('section')){
                switch ($request->section){
                    case "Company Details":
                        $country = $this->countries->findByUuid($request->country_id);
                        $inputs = $request->except(['country']);
                        if($country){ $inputs['country_id'] = $country->id; }
                        $practice->update($inputs);
                        break;
                    case "Statutory Information":
                        $country = $this->countries->findByUuid($request->country_id);
                        $statutory = $practice->statutories()->get()->first();
                        $inputs = $request->except(['country']);
                        if($country){ $inputs['country_id'] = $country->id; }
                        if($statutory){
                            $statutory->update($inputs);
                        }else{
                            $practice->statutories()->create($inputs);
                        }
                        break;
                    case "Customer Zone Settings":
                        $inputs = $request->all();
                        $customer_zone = $practice->customerZone()->get()->first();
                        if($customer_zone){
                            $customer_zone->update($inputs);
                        }else{
                            $practice->customerZone()->create($inputs);
                        }
                        break;
                    case "Financial Years":
                        $practiceFinanceSetting = $this->financialYears->findByUuid($request->id);
                        $inputs = $request->all();
                        $inputs['financial_year_start'] = $this->helper->format_lunox_date($inputs['financial_year_start']);
                        $inputs['financial_year_end'] = $this->helper->format_lunox_date($inputs['financial_year_end']);
                        $practiceFinanceSetting->update($inputs);
                        break;
                    case "Outstanding Balances":
                    case "Regional Settings":
                    case "Rounding":
                        $inputs = $request->except(['section']);
                        $general_setting = $practice->generalSettings()->get()->first();
                        $general_setting->update($inputs);
                        break;
                    case "Customer and Supplier Settings":
                        $inputs = $request->except(['section']);
                        $customer_supplier_setting = $practice->customerSupplierSettings()->get()->first();
                        $customer_supplier_setting->update($inputs);
                        break;
                    case "Item Settings":
                    case "Warehouses":
                        $inputs = $request->except(['section']);
                        $inventory_settings = $practice->inventorySettings()->get()->first();
                        if($inventory_settings){
                            $inventory_settings->update($inputs);
                        }else{
                            $inventory_settings = $practice->inventorySettings()->create($inputs);
                        }
                        break;
                    case "VAT Settings":
                        $inputs = $request->except(['section']);
                        if($request->id){
                            $vat_system = $this->practiceTax->findByUuid($request->id);
                            $vat_system->update($inputs);
                        }else{
                            $parent_owner = $practice->owner()->get()->first();
                            $vat_system = $parent_owner->taxation()->create($inputs);
                        }
                        break;
                    case "Branding":
                        $doc_tmp_name = $_FILES['file']['tmp_name'];
                        $root_directory_array = $this->helper->create_logo_directory($practice->uuid);
                        $newFilePath = $root_directory_array['file_server_root'].'/'.$_FILES['file']['name'];
                        $file_path = $root_directory_array['file_public_access'].'/'.$_FILES['file']['name'];
                        $practiceAssets = $practice->assets()->get()->first();
                        $file_type = $_FILES['file']['type'];
                        $file_name = $_FILES['file']['name'];
                        $file_size = $_FILES['file']['size'];
                        $inputs['file_name'] = $file_name;
                        $inputs['file_path'] = $file_path;
                        $inputs['file_mime'] = $file_type;
                        $inputs['file_size'] = round(($file_size/1000000),2).'MB';
                        if(move_uploaded_file($doc_tmp_name, $newFilePath)){
                            if($practiceAssets){
                                $practiceAssets = $practice->assets()->update($inputs);
                            }else{
                                $practiceAssets = $practice->assets()->create($inputs);
                            }
                            $http_resp['description'] = "Company Logo successful saved";
                        }
                        break;
                    case "Document Prefix":
                    case "Document Title":
                    case "Document Messages":
                    case "Email Signatures":
                        $inputs = $request->all();
                        $transaction_documents = json_decode($inputs['transaction_documents'], true);
                        for ( $i=0; $i < sizeof($transaction_documents); $i++ ){
                            $trans_doc = $this->practiceTransactionDocument->findByUuid($transaction_documents[$i]['id']);
                            $trans_doc->update($transaction_documents[$i]);
                        }
                        break;
                    case "Opening Balance":
                        $inputs = $request->all();
                        $accounts = json_decode($inputs['accounts'], true);
                        $as_of = $inputs['as_of'];
                        //Log::info($accounts);
                        //Accounts Group
                        for ( $i=0; $i < sizeof($accounts); $i++ ){
                            //Accounts inside this group
                            $account_list = $accounts[$i]['accounts'];
                            for ($k=0; $k<sizeof($account_list); $k++){
                                //Check if Debit or Credit is Provided
                                $debit_balance = $account_list[$k]['opening_balance_debited'];
                                $credit_balance = $account_list[$k]['opening_balance_credited'];
                                $ac_name = $account_list[$k]['name'];
                                $ac_uuid = $account_list[$k]['id'];
                                $amount = 0;
                                $debit_side = false;
                                $credit_side = false;
                                if($debit_balance && $credit_balance){
                                    //In opening balance, you provide only one side of the double entry i.e "Debit" or "Credit", not both
                                    //So here rollback the database and return 422(Payload issues) error alert
                                    $http_resp = $this->response_type['422'];
                                    $http_resp['errors'] = ["Error at Account: '".$ac_name."'. Opening Balance can either be 'Debit' or 'Credit' not both"];
                                    Log::info("Opening Balance with both: Debit and Credit Balances");
                                    DB::connection(Module::MYSQL_DB_CONN)->rollBack();
                                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                                    return response()->json($http_resp,422);
                                }elseif($debit_balance>0){
                                    $debit_side = true;
                                    $amount = $debit_balance;
                                }elseif ($credit_balance>0){
                                    $credit_side = true;
                                    $amount = $credit_balance;
                                }
                                else{
                                    $amount = 0;
                                }

                                //Accounting Can proceed
                                if($amount > 0){
                                    //Here you can either Create New "Opening Balance Entry" or Edit/Update existing "Opening Balance Entry"

                                    $op_bal_equity = $practice->chart_of_accounts()->where('default_code',$this->AC_OPENING_BALANCE_EQUITY_CODE)->get()->first();
                                    $company_coa_account = $this->chartOfAccounts->findByUuid($ac_uuid);
                                    $account_type = $this->accountTypes->find($company_coa_account->getAccountTypeId());
                                    $account_nature = $account_type->accounts_natures()->get()->first();
                                    $trans_type = $this->TRANS_NAME_OPEN_BALANCE;
                                    $trans_name = "Account ".$trans_type;
                                    $transaction_id = $this->helper->getToken(10);
                                    $commit_journal_entry = false; //This flag is used to determine whether to perform double entry or not

                                    if($account_nature->name == $this->ASSETS){
                                        //Assets : [Dr | Cr]==["New Ac" - "Opening Balance Equity"] Transaction is called "Opening Balance"
                                        $debited_ac = $company_coa_account->code;
                                        $credited_ac = $op_bal_equity->code;
                                        if($credit_side){
                                            $debited_ac = $op_bal_equity->code;
                                            $credited_ac = $company_coa_account->code;
                                        }
                                        $commit_journal_entry = true;
                                    }elseif ( ($account_nature->name==$this->LIABILITY) || ($account_nature->name==$this->EQUITY) ){
                                        //Equity : [Dr | Cr]==["Opening Balance Equity" | "New Ac"] Transaction is called "Journal Entry"
                                        //Liability : [Dr | Cr]==["Opening Balance Equity" | "New Ac"] Transaction is called "Journal Entry"
                                        $debited_ac = $op_bal_equity->code;
                                        $credited_ac = $company_coa_account->code;
                                        if($debit_side){
                                            $debited_ac = $company_coa_account->code;
                                            $credited_ac = $op_bal_equity->code;
                                        }
                                        $commit_journal_entry = true;
                                    }else{ //Do not allow Opening Balance Entry
                                        $commit_journal_entry = false;
                                        $debited_ac = null;
                                        $credited_ac = null;
                                    }

                                    if($commit_journal_entry){
                                        $inputs['amount'] = $amount;
                                        $inputs['reason'] = "Opening balance";
                                        $op_balance = $company_coa_account->openingBalances()->get()->first();
                                        if($op_balance){ //This Opening Balance Transaction already exits
                                            //Get Ledger Support Document
                                            $op_balance->update($inputs);
                                            $supportDoc = $op_balance->double_entry_support_document()->get()->first();
                                            //Get Journal Entry
                                            $journalEntry = $supportDoc->journalEntries()->get()->first();
                                            $journalEntry->amount = $amount;
                                            $journalEntry->debited = $debited_ac;
                                            $journalEntry->credited = $credited_ac;
                                            $journalEntry->save();
                                        }else{ //Opening Balance Transaction does not exits
                                            $op_balance = $practice->accountOpeningBalances()->create($inputs);
                                            $op_balance = $company_coa_account->openingBalances()->save($op_balance);
                                            $supportDocument = $op_balance->double_entry_support_document()->create(['trans_type'=>$trans_type]);
                                            $double_entry = $this->accountingVouchers->accounts_double_entry($practice,$debited_ac,$credited_ac,$amount,$as_of,$trans_name,$transaction_id);
                                            $double_entry->supports()->save($supportDocument);
                                        }
                                    }
                                }
                            }
                        }
                        break;
                }
                $http_resp['description'] = "Changes successful saved!";
            }
        }catch(\Exception $e){
            $http_resp = $this->response_type['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_DB_CONN)->commit();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){
        //
        $http_resp = $this->response_type['200'];
        $company = $this->practice->findByUuid($uuid);
        //Users
        $users = array();
        $trans_data = $this->practice->transform_($company);
        $company_users = $company->users()->orderByDesc('created_at')->paginate(10);
        foreach ($company_users as $company_user) {
            array_push($users,$this->practiceUser->transform_user($company_user));
        }
        //Addresses
        $addresses = $company->addresses()->get();
        $address_array = array();
        foreach ($addresses as $address){
            $temp_addr['id'] = $address->uuid;
            $temp_addr['address'] = $address->address;
            array_push($address_array,$temp_addr);
        }
        //Country
        $country = $company->countries()->get()->first();
        if($country){
            $trans_data['country'] = $this->countries->transform_country($country);
        }

        //Statutory
        $statutory = $company->statutories()->get()->first();
        if($statutory){
            $statutory_data = $this->practice->transform_statutory($statutory);
            $countr = $statutory->countries()->get()->first();
            if($countr){
                $statutory_data['country'] = $this->countries->transform_country($countr);
            }
            $trans_data['statutory'] = $statutory_data;
        }else{
            $trans_data['statutory'] = null;
        }
        //Customer Zone
        $customer_zone = $company->customerZone()->get()->first();
        if($customer_zone){
            $trans_data['customer_zone'] = $this->practice->transformCustomerZone($customer_zone);
        }else{
            $trans_data['customer_zone'] = null;
        }

        //Financial Years
        $accounting_period = [];
        $financial_years = $company->financialSettings()->get();
        foreach ($financial_years as $financial_year){
            array_push($accounting_period,$this->practice->transformFinancialSettings($financial_year));
        }
        $trans_data['financial_years'] = $accounting_period;

        //General Settings
        $general_settings = $company->generalSettings()->get()->first();
        if ($general_settings){
            $trans_data['general_settings'] = $this->practice->transformGeneralSettings($general_settings);
        }else{
            $trans_data['general_settings'] = null;
        }

        //Customer Supplier Settings
        $customer_supplier_setting = $company->customerSupplierSettings()->get()->first();
        if($customer_supplier_setting){
            $trans_data['customer_supplier_setting'] = $this->practice->transformCustomerSupplierSettings($customer_supplier_setting);
        }else{
            $trans_data['customer_supplier_setting'] = null;
        }

        //Inventory Settings
        $inventory_settings = $company->inventorySettings()->get()->first();
        if($inventory_settings){
            $trans_data['inventory_settings'] = $this->practice->transformInventorySettings($inventory_settings);
        }else{
            $trans_data['inventory_settings'] = null;
        }

        //Taxation System
        $company_owner = $company->owner()->get()->first();
        $vat = $company_owner->taxation()->get()->first();
        if($vat){
            $vat_types_array = array();
            $vat_types = $company->practiceVatTypes()->get();
            foreach ($vat_types as $vat_type){
                array_push($vat_types_array,$this->practice->transformPracticeTaxation($vat_type));
            }
            $vat_data = $this->practice->transformPracticeTax($vat);
            $vat_data['vat_types'] = $vat_types_array;
            $trans_data['vat'] = $vat_data;
        }else{
            $trans_data['vat'] = null;
        }

        //Practice Transaction Documents
        $transaction_documents = $company->transactionDocuments()->get();
        $trans_data['transaction_documents'] = array();
        foreach ($transaction_documents as $transaction_document){
            array_push($trans_data['transaction_documents'],$this->practice->transformPracticeTransactionDocument($transaction_document));
        }

        //Company Assets
        $assets = $company->assets()->get()->first();
        if($assets){
            $trans_data['assets'] = $this->practice->transformAsset($assets);
        }else{
            $trans_data['assets'] = null;
        }

        $trans_data['users'] = $users;
        $trans_data['addresses'] = $address_array;
        $http_resp['results'] = $trans_data;
        return response()->json($http_resp);
    }

}
