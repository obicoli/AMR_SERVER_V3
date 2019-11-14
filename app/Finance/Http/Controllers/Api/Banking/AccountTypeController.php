<?php

namespace App\Finance\Http\Controllers\Api\Banking;

use App\Finance\Models\Banks\AccountBankAccountType;
use App\Finance\Repositories\FinanceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Controller;

class AccountTypeController extends Controller
{
    protected $accountBankAccountType;
    protected $http_response;
    public function __construct(AccountBankAccountType $accountBankAccountType)
    {
        $this->http_response = Config::get('response.http');
        $this->accountBankAccountType = new FinanceRepository($accountBankAccountType);
    }

    public function index(Request $request){
        $http_resp = $this->http_response['200'];
        $results = array();
        $account_types = AccountBankAccountType::all()->sortBy('name');
        foreach($account_types as $account_type){
            array_push($results,$this->accountBankAccountType->transform_bank_account_types($account_type));
        }
        $http_resp['results'] = $results;
        return response()->json($http_resp);
    }
    
}
