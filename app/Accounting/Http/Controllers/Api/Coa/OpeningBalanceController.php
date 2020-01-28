<?php

namespace App\Accounting\Http\Controllers\Api\Coa;

// use App\Accounting\Models\Banks\AccountBankAccountType;
// use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsNature;
use App\Accounting\Models\COA\AccountsOpeningBalance;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
use App\Customer\Models\Customer;
use App\Customer\Repositories\CustomerRepository;
use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Models\Banks\AccountMasterBank;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Product\ProductTaxation;
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OpeningBalanceController extends Controller
{
    protected $accountsOpeningBalance;
    protected $chartOfAccounts;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $accountTypes;
    protected $accountsCoa;
    protected $accountingVouchers;
    protected $customers;
    protected $suppliers;
    protected $accountNatures;
    protected $productTaxation;

    public function __construct(AccountsOpeningBalance $accountsOpeningBalance)
    {
        $this->http_response = Config::get('response.http');
        $this->accountsOpeningBalance = new AccountingRepository($accountsOpeningBalance);
        $this->chartOfAccounts = new AccountingRepository( new AccountChartAccount() );
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->customers = new CustomerRepository(new Customer());
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->accountNatures = new AccountingRepository( new AccountsNature() );
        $this->productTaxation = new PracticeRepository( new ProductTaxation() );
    }

    public function create(Request $request){

        $http_resp = $this->http_response['200'];
        $rule = [
            'amount'=>'required',
            'account_id'=>'required',
            'notes'=>'required',
            'as_at'=>'required',
        ];
        $validation = Validator::make($request->all(),$rule,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $inputs = $request->except(['account_id']);
            $chartOfAccount = $this->chartOfAccounts->findByUuid($request->account_id);
            $op_balance = $chartOfAccount->openingBalances()->get()->first();
            if($op_balance){
                //Get Ledger Support Document
                $supportDoc = $op_balance->double_entry_support_document()->get()->first();
                //Get Journal Entry
                $journalEntry = $supportDoc->journalEntries()->get()->first();
            }else{
                $op_balance = $chartOfAccount->openingBalances()->create($inputs);
            }
            $http_resp['description'] = "Account balance successful adjusted!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
        return response()->json($http_resp);

    }
}
