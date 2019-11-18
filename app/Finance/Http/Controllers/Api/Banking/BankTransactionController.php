<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;
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

class BankTransactionController extends Controller
{
    protected $bankTransaction;
    protected $http_response;
    protected $helper;
    protected $practices;
    protected $bankAccounts;

    public function __construct(BankTransaction $bankTransaction)
    {
        $this->http_response = Config::get('response.http');
        $this->bankTransaction = new FinanceRepository($bankTransaction);
        $this->helper = new HelperFunctions();
        $this->practices = new PracticeRepository( new Practice() );
        $this->bankAccounts = new FinanceRepository( new AccountsBank() );
    }

    public function index(Request $request){}


    public function create(Request $request){
        Log::info($request);
        $http_resp = $this->http_response['200'];
        $rules = [
            'bank_account'=>'required',
            'transactions'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->beginTransaction();
        try{

            $company = $this->practices->find($request->user()->company_id);
            $bankAccount = $this->bankAccounts->findByUuid($request->bank_account);
            
            $new_transaction_array = array();
            $exist_transaction_array = array();

            if($request->has('action_taken')){
                switch($request->action_taken){
                    case "Save":
                        $missing = 0;
                        if( is_array($request->transactions) ){
                            $transactions = $request->transactions;
                            for ($i=0; $i < sizeof($transactions); $i++) {
                                $tranction = $transactions[$i];
                                //Ensure every field is provided in transaction
                                if( $tranction['transaction_date']=='' || $tranction['payee']=='' || $tranction['description']=='' || $tranction['type']=='' || $tranction['selection']=='' || $tranction['reference']=='' ){
                                    $transactions[$i]['error'] = true;
                                    $transactions[$i]['error_msg'] = "This row!";
                                    $transactions[$i]['is_date'] = true;
                                    //Rollback & Report
                                    DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
                                    DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                                    $http_resp = $this->http_response['422'];
                                    $http_resp['errors'] = $transactions;
                                    return response()->json($http_resp,422);
                                }else{
                                    //Transaction inputs provided so process it
                                    //Check if Transaction "id" is not null and do basic updates
                                    //If Transaction has "id" is NULL
                                    if( $transactions[$i]['id'] == null ){ //Create New Transaction

                                        $inputs['transaction_date'] = $transactions[$i]['transaction_date'];
                                        $inputs['reference'] = $transactions[$i]['reference'];
                                        $inputs['bank_account_id'] = $bankAccount->id;
                                        $inputs['payee'] = $transactions[$i]['payee'];
                                        $inputs['description'] = $transactions[$i]['description'];
                                        $transacted = $this->bankTransaction->create($inputs);
                                        //Create New Transaction
                                        //

                                    }else{ //Get Transaction and do basic update
                                        //SPECIAL EDITS: amount,type,selection,status(reconciled)
                                        $transacted = $this->bankTransaction->findByUuid($transactions[$i]['id']);
                                        $inputs = [];
                                        $inputs['transaction_date'] = $transactions[$i]['transaction_date'];
                                        $inputs['reference'] = $transactions[$i]['reference'];
                                        $inputs['payee'] = $transactions[$i]['payee'];
                                        $inputs['description'] = $transactions[$i]['description'];
                                        $transacted = $this->bankTransaction->update($inputs,$transacted->id);
                                    }

                                }
                            }
                        }
                    break;
                }
            }
            $http_resp['description'] = "Transactions successful saved!";

        }catch(\Exception $e){
            $http_resp = $this->http_response['500'];
            Log::info($e);
            DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_ACCOUNTING_DB_CONN)->rollBack();
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
        return response()->json($http_resp);
    }

    public function show($uuid){
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->bankTransaction->transform_bank_transaction($this->bankTransaction->findByUuid($uuid));
        return response()->json($http_resp);
    }

    public function update(Request $request,$uuid){}

    public function destroy($uuid){}

}
