<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Finance\Models\Banks\BankTransaction;
use App\Finance\Repositories\FinanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class BankTransactionController extends Controller
{
    protected $bankTransaction;
    protected $http_response;
    public function __construct(BankTransaction $bankTransaction)
    {
        $this->http_response = Config::get('response.http');
        $this->bankTransaction = new FinanceRepository($bankTransaction);
    }

    public function index(Request $request){}
    public function create(Request $request){}
    public function show($uuid){
        $http_resp = $this->http_response['200'];
        $http_resp['results'] = $this->bankTransaction->transform_bank_transaction($this->bankTransaction->findByUuid($uuid));
        return response()->json($http_resp);
    }
    public function update(Request $request,$uuid){}
    public function destroy($uuid){}
}
