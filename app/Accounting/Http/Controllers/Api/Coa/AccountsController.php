<?php

namespace App\Accounting\Http\Controllers\Api\Coa;

// use App\Accounting\Models\Banks\AccountBankAccountType;
// use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsNature;
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

class AccountsController extends Controller
{
    protected $accountChartAccount;
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

    public function __construct(AccountsCoa $accountsCoa)
    {
        $this->http_response = Config::get('response.http');
        $this->accountsCoa = new AccountingRepository($accountsCoa);
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountChartAccount = new AccountingRepository( new AccountChartAccount() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->customers = new CustomerRepository(new Customer());
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->accountNatures = new AccountingRepository( new AccountsNature() );
        $this->productTaxation = new PracticeRepository( new ProductTaxation() );
    }

    public function index(Request $request){
        //Log::info($request);
        $http_resp = $this->http_response['200'];
        $results = array();
        $company = $this->practices->find($request->user()->company_id);
        //Get Chart of Accounts under this company //
        if($request->has('type_id')){
            $account_type = $this->accountTypes->findByUuid($request->type_id);
            $accounts = AccountsCoa::where('accounts_type_id',$account_type->id)
                ->where('owning_id',null)
                ->where('owning_type',null)
                ->paginate(500);
        }
        else{
            $accounts = AccountsCoa::paginate(15);
        }

        $paged_data = $this->helper->paginator($accounts);
        foreach ($accounts as $account) {
            array_push($paged_data['data'],$this->accountsCoa->transform_default_coa($account));
        }
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }
}
