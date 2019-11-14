<?php

namespace App\Finance\Http\Controllers\Api\Banking;

// use App\Accounting\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountMasterBank;
use App\Finance\Models\Banks\AccountMasterBankBranch;
use App\Finance\Models\Banks\AccountsBank;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;

use App\Accounting\Repositories\AccountingRepository;
use App\Finance\Repositories\FinanceRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
// use App\Models\Account\Banks\AccountsBankBranch;
// use App\Accounting\Models\Banks\AccountMasterBankBranch;
use App\Models\Module\Module;
use Illuminate\Support\Facades\Log;

class BanksBranchController extends Controller
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
        $this->accountsBankBranch = new FinanceRepository(new AccountMasterBankBranch());
    }

    public function index(Request $request){
        $http_resp = $this->response_type['200'];
        $banks = $this->accountsBankBranch->all();
        $results = array();
        foreach($banks as $bank){
            array_push($results, $this->accountsBanks->transform_bank_branch($bank));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid){}

    public function destroy($uuid){

        $http_resp = $this->response_type['200'];
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $bank = $this->accountsBankBranch->findByUuid($uuid);
            $bank->delete();
            $http_resp['description'] = "Branch successful deleted!";

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
            'address'=>'required|max:255',
            'bank_id' => 'required',
        ];
        $validator = Validator::make($request->all(),$rule, $this->helper->messages());
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $bank = $this->accountsBanks->findByUuid($request->bank_id);
            if($bank->branches()->where('name',$request->name)->get()->first()){
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ["Branch name already in use!"];
                return response()->json($http_resp,422);
            }
            if($bank->branches()->where('code',$request->code)->get()->first()){
                DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                $http_resp = $this->response_type['422'];
                $http_resp['errors'] = ["Branch code already in use!"];
                return response()->json($http_resp,422);
            }
            $branch = $bank->branches()->create($request->except(['bank','bank_id']));
            $http_resp['description'] = "Branch successful created!";

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
            'bank_id'=>'required',
            'address' => 'required',
        ];
        $validator = Validator::make($request->all(),$rule, $this->helper->messages());
        if ($validator->fails()){
            $http_resp = $this->response_type['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validator->errors());
            return response()->json($http_resp,422);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{
            $bank = $this->accountsBanks->findByUuid($request->bank_id);
            $bank_branch = $this->accountsBankBranch->findByUuid($uuid);
            $inputs = $request->all();
            $inputs['bank_id'] = $bank->id;
            $bank_branch->update($inputs);
            $http_resp['description'] = "Branch successful updated!";
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
