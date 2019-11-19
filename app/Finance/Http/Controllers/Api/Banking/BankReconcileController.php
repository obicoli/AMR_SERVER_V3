<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Finance\Models\Banks\BankReconciliation;
use App\Finance\Repositories\FinanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class BankReconcileController extends Controller
{
    protected $bankReconciliation;
    protected $http_response;
    public function __construct(BankReconciliation $bankReconciliation)
    {
        $this->http_response = Config::get('response.http');
        $this->bankReconciliation = new FinanceRepository($bankReconciliation);
    }
    
    public function index(Request $request){}
    public function create(Request $request){}
    public function show($uuid){
        /*
            The common reasons for a difference between the bank balance and the general ledger book balance are:
                Outstanding checks (checks written but not yet clearing the bank)
                Deposits in transit (company receipts that are not yet deposited in the bank)
                Bank service charges and other bank fees
                Check printing charges
                Errors in entering amounts in the company's general ledger
        */
    }
    public function update(Request $request,$uuid){}
    public function destroy($uuid){}

}
