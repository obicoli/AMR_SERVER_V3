<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Finance\Models\Banks\AccountMasterBank;
//use App\Accounting\Repositories\AccountingRepository as AppAccountingRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Repositories\Practice\PracticeRepository;
use App\Models\Practice\Practice;

use App\Accounting\Repositories\AccountingRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use App\Models\Account\Banks\AccountsBankBranch;
use App\Finance\Models\Banks\AccountMasterBankBranch;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Repositories\FinanceRepository;
use App\Models\Module\Module;
use Illuminate\Support\Facades\Log;

class BanksController extends Controller
{
    protected $accountsBanks;
    protected $accountsBankBranch;
    protected $response_type;
    protected $helper;
    // protected $practice;
    // protected $practiceBank;

    public function __construct(AccountMasterBank $accountsBanks)
    {
        $this->accountsBanks = new FinanceRepository($accountsBanks);
        $this->response_type = Config::get('response.http');
        $this->helper = new HelperFunctions();
        // $this->practice = new PracticeRepository(new Practice());
        // $this->practiceBank = new AccountingRepository(new PracticeBank());
        $this->accountsBankBranch = new FinanceRepository(new AccountMasterBankBranch());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $banks = $this->accountsBanks->all();
        $results = array();
        foreach($banks as $bank){
            array_push($results, $this->accountsBanks->transform_bank($bank));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){}

    public function destroy($uuid){

        $http_resp = $this->response_type['200'];
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $bank = $this->accountsBanks->findByUuid($uuid);
            $bank->delete();
            $http_resp['description'] = "Bank successful deleted!";

        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);

    }

    public function create(Request $request){
        $http_resp = $this->response_type['200'];
        $rule = [
            'name'=>'required',
            'code'=>'required',
            'description'=>'required|max:255',
            'comments' => 'sometimes|required|max:255',
            'address' => 'sometimes|required|max:255',
        ];
        $validator = Validator::make($request->all(),$rule, $this->helper->messages());
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $bank = $this->accountsBanks->create($request->all());
            $http_resp['description'] = "Bank successful created!";
        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function update(Request $request, $uuid){
        $http_resp = $this->response_type['200'];
        $rule = [
            'name'=>'required',
            'code'=>'required',
            'description'=>'required|max:255',
            'comments' => 'sometimes|required|max:255',
            'address' => 'sometimes|required|max:255',
        ];
        $validator = Validator::make($request->all(),$rule, $this->helper->messages());
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $bank = $this->accountsBanks->findByUuid($uuid);
            $bank->update($request->except(['id']));
            $http_resp['description'] = "Bank successful updated!";
        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            $http_resp = $this->response_type['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->commit();
        return response()->json($http_resp);
    }

}
