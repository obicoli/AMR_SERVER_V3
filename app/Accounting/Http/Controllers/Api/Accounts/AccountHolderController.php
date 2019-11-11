<?php

namespace App\Accounting\Http\Controllers\Api\Accounts;

use App\Accounting\Models\COA\AccountsHolder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\helpers\HelperFunctions;
use App\Models\Practice\Practice;
use App\Accounting\Repositories\AccountingRepository;
use App\Repositories\Practice\PracticeRepository;

class AccountHolderController extends Controller
{
    protected $http_response;
    protected $practices;
    protected $helper;
    protected $accountHolders;
    public function __construct()
    {
        $this->http_response = Config::get('response.http');
        $this->practices = new PracticeRepository( new Practice() );
        $this->helper = new HelperFunctions();
        $this->accountHolders = new AccountingRepository( new AccountsHolder() );
    }

    public function show(Request $request, $uuid){

        $http_resp = $this->http_response['200'];
        $company_id = $request->user()->company_id;
        $company = $this->practices->find($company_id);
        $accountHolder = $this->accountHolders->findByUuid($uuid);
        $http_resp['results'] = $this->accountHolders->account_statement($company,$accountHolder);
        return response()->json($http_resp);

    }

}
