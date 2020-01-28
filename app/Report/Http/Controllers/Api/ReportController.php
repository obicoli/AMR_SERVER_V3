<?php

namespace App\Report\Http\Controllers\Api;

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
use App\Report\Models\Reporting;
use App\Repositories\Practice\PracticeRepository;
use App\Supplier\Models\Supplier;
use App\Supplier\Repositories\SupplierRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    //
    protected $reporting;
    protected $http_response;
    protected $practices;
    protected $helper;

    public function __construct(Reporting $reporting)
    {
        $this->http_response = Config::get('response.http');
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
    }

    public function index(Request $request){

        $http_resp = $this->http_response['200'];
        $results = array();
        if($request->has('section')){
            $reportings = Reporting::where('section',$request->section)->paginate(100);
        }else{
            $reportings = Reporting::paginate(20);
        }

        $paged_data = $this->helper->paginator($reportings);
        foreach($reportings as $reporting){
            $temp['id'] = $reporting->uuid;
            $temp['name'] = $reporting->name;
            $temp['section'] = $reporting->section;
            $temp['description'] = $reporting->description;
            array_push($results,$temp);
        }
        $paged_data['data'] = $results;
        $http_resp['results'] = $paged_data;
        return response()->json($http_resp);
    }
}
