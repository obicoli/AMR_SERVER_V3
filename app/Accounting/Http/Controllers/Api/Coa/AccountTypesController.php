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
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\Log;

class AccountTypesController extends Controller
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

    public function __construct(AccountsType $accountTypes)
    {
        $this->http_response = Config::get('response.http');
        $this->accountTypes = new AccountingRepository($accountTypes);
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        //$this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
        $this->customers = new CustomerRepository(new Customer());
        $this->suppliers = new SupplierRepository( new Supplier() );
        $this->accountNatures = new AccountingRepository( new AccountsNature() );
    }

    public function index(){
        $http_resp = $this->http_response['200'];
        $datas = $this->accountTypes->all(100);
        $paged_data = $this->helper->paginator($datas);
        $results = array();
        foreach($datas as $dat){
            array_push($results,$this->accountTypes->transform_account_type($dat));
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }
}
