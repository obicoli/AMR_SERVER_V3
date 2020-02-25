<?php

namespace App\Http\Middleware;

use App\Models\Practice\Practice;
use App\Models\Practice\PracticeUser;
use App\Repositories\Practice\PracticeRepository;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class CompanyUserAccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $logged_user = $request->user();
        $http_api_response = Config::get('response.http');
        $practiceUserRepository = new PracticeRepository( new PracticeUser() );
        $practiceRepository = new PracticeRepository( new Practice() );
        $company = $practiceRepository->find($logged_user->company_id);
        $practiceUser = $practiceUserRepository->findByUserAndCompany($logged_user,$company);
        if($practiceUser && $practiceUser->getCanAccessCompany()){
            return $next($request);
        }else{
            $http_resp = $http_api_response['403'];
            return response()->json($http_resp,403);
        }
    }
}
