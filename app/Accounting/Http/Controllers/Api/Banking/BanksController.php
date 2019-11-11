<?php

namespace App\Accounting\Http\Controllers\Api\Banking;

use App\Accounting\Models\Banks\AccountMasterBank;
use App\Accounting\Repositories\AccountingRepository as AppAccountingRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Account\Banks\AccountsBank;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;
use App\Repositories\Accounts\AccountingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Practice\Accounting\PracticeBank;
use App\Models\Account\Banks\AccountsBankBranch;

class BanksController extends Controller
{
    protected $accountMasterBank;
    // protected $accountsBankBranch;
    // protected $response_type;
    // protected $helper;
    // protected $practice;
    // protected $practiceBank;

    public function __construct(AccountMasterBank $accountMasterBank)
    {
        $this->accountMasterBank = new AppAccountingRepository($accountMasterBank);
        // $this->response_type = Config::get('response.http');
        // $this->helper = new HelperFunctions();
        // $this->practice = new PracticeRepository(new Practice());
        // $this->practiceBank = new AccountingRepository(new PracticeBank());
        // $this->accountsBankBranch = new AccountingRepository(new AccountsBankBranch());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $banks = $this->accountsBank->all();
        $http_resp['results'] = $this->accountsBank->tranform_banks($banks, "banks");
        return response()->json($http_resp);
    }

    //branch_index
    // public function branch_index(){
    //     $http_resp = $this->response_type['200'];
    //     $banks = $this->accountsBankBranch->all();
    //     $http_resp['results'] = $this->accountsBank->tranform_banks($banks, "branches");
    //     return response()->json($http_resp);
    // }

    public function show(Request $request, $uuid){}

    // public function practice($practice_uuid){
    //     $http_resp = $this->response_type['200'];
    //     $practice = $this->practice->findByUuid($practice_uuid);
    //     $banks = $this->practiceBank->getByPractice($practice);
    //     $http_resp['results'] = $this->accountsBank->tranform_banks($banks);
    //     return response()->json($http_resp);
    // }

    public function delete($uuid){}

    public function create(Request $request){

        $http_resp = $this->response_type['200'];

        $rule = [
            'name'=>'required',
            'branch_name'=>'required',
            'branch_code'=>'required',
            'accounts_title'=>'required',
            'accounts_number'=>'required|unique:accounts_banks',
            'accounts_type'=>'required',
        ];

        $validator = Validator::make($request->all(),$rule, $this->helper->messages());
        if ($validator->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }

        DB::beginTransaction();

        DB::commit();
        return response()->json($http_resp);

    }

    public function update(Request $request, $uuid){}

}
