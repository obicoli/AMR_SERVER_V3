<?php

namespace App\Accounting\Http\Controllers\Api\Banking;

use App\Accounting\Models\Banks\AccountBankAccountType;
use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\Banks\AccountMasterBankBranch;
use App\Accounting\Models\Banks\AccountsBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BanksAccountsController extends Controller
{
    protected $accountsBank;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $banks;
    protected $bank_branches;
    protected $bank_account_types;
    // protected $accountTypes;
    // protected $accountsCoa;
    // protected $accountingVouchers;
    // protected $customers;

    public function __construct(AccountsBank $accountsBank)
    {
        $this->http_response = Config::get('response.http');
        $this->accountsBank = new AccountingRepository($accountsBank);
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->banks = new AccountingRepository( new AccountMasterBank() );
        $this->bank_branches = new AccountingRepository( new AccountMasterBankBranch() );
        $this->bank_account_types = new AccountingRepository( new AccountBankAccountType() );
        // $this->accountTypes = new AccountingRepository( new AccountsType() );
        // $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        // $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        // $this->customers = new CustomerRepository(new Customer());
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        $accounts = $company->bank_accounts()->get();
        foreach( $accounts as $account ){
            array_push($results,$this->accountsBank->transform_bank_accounts($account));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);

    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rule = [
            'account_name'=>'required',
            'account_number'=>'required',
            'bank_id'=>'required',
            'bank_branch_id'=>'required',
            'bank_account_type_id'=>'required'
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $company = $this->practices->find($request->user()->company_id);
            $bank = $this->banks->findByUuid($request->bank_id);
            $bank_branch = $this->bank_branches->findByUuid($request->bank_branch_id);
            $bank_account_type = $this->bank_account_types->findByUuid($request->bank_account_type_id);
            //check if this
            if( $company->bank_accounts()->where('account_number',$request->account_number)->get()->first() ){
                $http_resp = $this->http_response['422'];
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp['errors'] = ['Account number already in use'];
                return response()->json($http_resp,422);
            }

            $inputs = $request->all();
            $inputs['account_type_id'] = $bank_account_type->id;
            $inputs['bank_id'] = $bank->id;
            $inputs['branch_id'] = $bank_branch->id;
            $new_bank_account = $company->bank_accounts()->create($inputs);

        }catch(\Exception $e){

            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);

        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);

    }

}
