<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Accounting\Models\COA\AccountsCoa;
use App\Finance\Models\Banks\AccountsBank;
use App\Finance\Models\Banks\BankReconciliation;
use App\Finance\Repositories\FinanceRepository;
use App\helpers\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;
use App\Models\Module\Module;
use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Repositories\Practice\PracticeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BankReconcileController extends Controller
{
    protected $bankReconciliation;
    protected $http_response;
    protected $helper;
    protected $bankAccounts;
    protected $companyUsers;
    protected $practices;
    public function __construct(BankReconciliation $bankReconciliation)
    {
        $this->http_response = Config::get('response.http');
        $this->bankReconciliation = new FinanceRepository($bankReconciliation);
        $this->helper = new HelperFunctions();
        $this->bankAccounts = new FinanceRepository( new AccountsBank() );
        $this->companyUsers = new PracticeRepository( new PracticeUser() );
        $this->practices = new PracticeRepository( new Practice() );
    }
    
    public function index(Request $request){}

    public function create(Request $request){
        Log::info($request);
        $http_resp = $this->http_response['200'];
        $rules = [
            'bank_account_id'=>'required',
            'reconcile'=>'required',
            'balance'=>'required',
            'statement_balance'=>'required',
            //'notes'=>'sometimes|required|max:255',
            'start_date'=>'required',
            'end_date'=>'required',
            'bank_reconciliation_id'=>'required',
            'last_reconciliation_id'=>'required',
        ];
        $validation = Validator::make($request->all(),$rules,$this->helper->messages());
        if ($validation->fails()){
            $http_resp = $this->http_response['422'];
            $http_resp['errors'] = $this->helper->getValidationErrors($validation->errors());
            return response()->json($http_resp,422);
        }

        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->beginTransaction();
        try{
            $user = $request->user();
            $inputs = $request->all();
            $company = $this->practices->find($user->company_id);
            $companyUser = $this->companyUsers->findByUserAndCompany($user,$company);
            $bankAccount = $this->bankAccounts->findByUuid($request->bank_account_id);
            $bankReconciliation = $this->bankReconciliation->findByUuid($request->bank_reconciliation_id);
            $previousReconciliation = $this->bankReconciliation->findByUuid($request->last_reconciliation_id);
            //The starting date must be one day after the date the selected bank account was last reconciled.
            //Verify the dates
            //Log::info( $this->helper->calculate_date_range( $previousReconciliation->end_date, $inputs['start_date']) );
            $one_day = 1 * 24 * 60 * 60;
            if( $this->helper->compare_two_dates( $inputs['start_date'], $inputs['end_date'] ) ){//Check if Start date is less
                if( $this->helper->calculate_date_range( $previousReconciliation->end_date, $inputs['start_date']) == $one_day ){
                    $this->bankReconciliation->reconcile_bank_transaction($companyUser,$bankReconciliation,null,$bankAccount,$inputs,AccountsCoa::RECONCILIATION_RECONCILED);
                }else{
                    DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                    $http_resp = $this->http_response['422'];
                    $http_resp['errors'] = ['The starting date must be one day after the date the selected bank account was last reconciled.'];
                    return response()->json($http_resp,422);
                }
                //$this->bankReconciliation->reconcile_bank_transaction($companyUser,$bankReconciliation,null,$bankAccount,$inputs,AccountsCoa::RECONCILIATION_RECONCILED);
            }else{
                DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
                $http_resp = $this->http_response['422'];
                $http_resp['errors'] = ['The starting date must be greater than end date.'];
                return response()->json($http_resp,422);
            }
        }catch(\Exception $e){
            Log::info($e);
            DB::connection(Module::MYSQL_FINANCE_DB_CONN)->rollBack();
            $http_resp = $this->http_response['500'];
            return response()->json($http_resp,500);
        }
        DB::connection(Module::MYSQL_FINANCE_DB_CONN)->commit();
        return response()->json($http_resp);
    }

    public function show(Request $request, $uuid,$bank_uuid=null){

        $http_resp = $this->http_response['200'];
        $show_reconciled = false;
        $filters = $this->helper->get_default_filter();

        Log::info($request);

        if($bank_uuid){ //Load Reconciliations in a given Bank
            $bankAccount = $this->bankAccounts->findByUuid($bank_uuid);
            if($request->has('filters')){
                $filters = $request->filters;
            }else{
                // $reconciliations = $bankAccount->bank_reconciliations()
                // ->whereRaw("start_date >= ? AND end_date <= ?",$filters)
                // ->orderByDesc('created_at')
                // ->paginate(2);
                $reconciliations = $bankAccount->bank_reconciliations()
                ->orderByDesc('id')
                ->paginate(2);
            }

            $paged_data = $this->helper->paginator($reconciliations);
            $paged_data['filters'] = $filters;
            $show_reconciled = false;
            if($request->has('show_reconciled')){
                if($request->show_reconciled=='show'){
                    $show_reconciled = true;
                }else{
                    $show_reconciled = false;
                }
            }
            foreach ($reconciliations as $reconciliation) {
                array_push($paged_data['data'],$this->bankReconciliation->transform_bank_reconciliation($reconciliation,$show_reconciled,$filters) );
            }
            $http_resp['results'] = $paged_data;
            return response()->json($http_resp);
        }

    }

    public function update(Request $request,$uuid){}
    public function destroy($uuid){}

    /*
        The common reasons for a difference between the bank balance and the general ledger book balance are:
        Outstanding checks (checks written but not yet clearing the bank)
        Deposits in transit (company receipts that are not yet deposited in the bank)
        Bank service charges and other bank fees
        Check printing charges
        Errors in entering amounts in the company's general ledger
    */

    /*
        Any time a bank transaction is Created, by default it will be attached to an "Open" Bank Reconciliation
        During the reconciliation Period, for incase this transaction is skipped, it will be forwarded to the next "Open" 
    */

}
