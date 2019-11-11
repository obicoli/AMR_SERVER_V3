<?php

namespace App\Accounting\Http\Controllers\Api\Reports;

use App\Accounting\Models\COA\AccountChartAccount;
use App\Accounting\Models\COA\AccountsCoa;
use App\Accounting\Models\COA\AccountsType;
use App\Accounting\Models\Voucher\AccountsVoucher;
use App\Accounting\Repositories\AccountingRepository;
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

class ReportsController extends Controller
{

    protected $accountChartAccount;
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $accountTypes;
    protected $accountsCoa;
    protected $accountingVouchers;

    public function __construct(AccountChartAccount $accountChartAccount)
    {
        $this->http_response = Config::get('response.http');
        $this->accountChartAccount = new AccountingRepository($accountChartAccount);
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountTypes = new AccountingRepository( new AccountsType() );
        $this->accountsCoa = new AccountingRepository( new AccountsCoa() );
        $this->accountingVouchers = new AccountingRepository( new AccountsVoucher() );
    }

    public function journals(Request $request){
        $http_resp = $this->http_response['200'];
        $res = array();
        //$temp_data = array();
        //Get the company
        $company = $this->practices->find($request->user()->company_id);
        //Get Vouchers Logs
        $vouchers_logs = $company->vouchers()->get()->groupBy('transaction_id'); //Sub Total Transactions(tbody)
        $temp_data['as_at'] = $this->helper->format_mysql_date( date('Y-m-d H:i:s'),'D jS M Y h:i A' );
        foreach ($vouchers_logs as $index => $vouchers_log){
            $temp_arr = array(); //Sub total Array
            foreach ($vouchers_log as $vouchers_lo){
                array_push($res,$this->accountingVouchers->create_journal_report($vouchers_lo));
            }
        }
        $temp_data['data'] = $res;
        $http_resp['results'] = $temp_data;
        return response()->json($http_resp);
    }

    public function ledgers(Request $request){
        $http_resp = $this->http_response['200'];
        $res = array();
        $company = $this->practices->find($request->user()->company_id);
        $res = $this->accountsCoa->create_general_ledger($company);
        $temp_data['data'] = $res;
        $temp_data['as_at'] = $this->helper->format_mysql_date( date('Y-m-d H:i:s'),'D jS M Y h:i A' );
        $http_resp['results'] = $temp_data;
        return response()->json($http_resp);
    }

    public function trail_balance(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        $temp_data['data'] = $this->accountsCoa->create_trail_balance($company);
        $temp_data['as_at'] = $this->helper->format_mysql_date( date('Y-m-d H:i:s'),'D jS M Y h:i A' );
        $http_resp['results'] = $temp_data;
        return response()->json($http_resp);
    }

    public function balance_sheet(Request $request){
        $http_resp = $this->http_response['200'];
        $company = $this->practices->find($request->user()->company_id);
        $temp_data['data'] = $this->accountsCoa->create_balance_sheet($company);
        $temp_data['as_at'] = $this->helper->format_mysql_date( date('Y-m-d H:i:s'),'D jS M Y h:i A' );
        $http_resp['results'] = $temp_data;
        return response()->json($http_resp);
    }
    
}
