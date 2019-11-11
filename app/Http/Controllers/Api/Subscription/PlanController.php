<?php

namespace App\Http\Controllers\Api\Subscription;

use App\Models\Subscription\Plan;
use App\Repositories\Subscription\PlanRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlanController extends Controller
{
    protected $plan;
    public function __construct(Plan $plan)
    {
        $this->plan = new PlanRepository($plan);
    }

}
