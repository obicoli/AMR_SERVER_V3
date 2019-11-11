<?php

namespace App\Http\Controllers\Api\Users;

use App\Repositories\User\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use jeremykenedy\LaravelRoles\Models\Permission;
use jeremykenedy\LaravelRoles\Models\Role;

class PermissionController extends Controller
{
    protected $permission;
    protected $response_type;

    public function __construct(Permission $permission)
    {
        $this->permission = new RoleRepository($permission);
        $this->response_type = Config::get('response.http');
    }

    public function index(){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->permission->formatPermissions();
        return response()->json($http_resp);
    }

    public function by_description($description){
        $http_resp = $this->response_type['200'];
        $http_resp['results'] = $this->permission->transform_collection($this->permission->getByDesc($description));
        return response()->json($http_resp);
    }
}
