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
        
    }
    public function update(Request $request,$uuid){}
    public function destroy($uuid){}

}
