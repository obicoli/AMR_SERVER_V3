<?php

namespace App\Http\Controllers\Api\Pharmacy;

use App\Models\Pharmacy\Pharmacy;
use App\Repositories\ModelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PharmacyController extends Controller
{
    protected $pharmacy;
    protected $model;

    public function __construct(Pharmacy $pharmacy)
    {
        $this->model = new ModelRepository($pharmacy);
    }

}
