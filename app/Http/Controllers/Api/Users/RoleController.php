<?php

namespace App\Http\Controllers\Api\Users;

use App\Repositories\User\RoleRepository;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use jeremykenedy\LaravelRoles\Models\Role;

class RoleController extends Controller
{
    protected $role;
    protected $response_type;

    public function __construct(Role $role)
    {
        $this->role = new RoleRepository($role);
        $this->response_type = Config::get('response.http');
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->role->all();
        return response()->json($http_resp);
    }

    public function by_description($description){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->role->transform_collection($this->role->getByDesc($description));
        return response()->json($http_resp);
    }

}
